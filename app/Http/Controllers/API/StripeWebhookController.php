<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        // Support both config/services + env (check multiple possible variable names)
        $secret = config('services.stripe.webhook_secret') 
            ?: env('STRIPE_WEBHOOK_SECRET') 
            ?: env('STRIPE_WEBHOOK_PAYMENTS_SECRET');

        if (!$secret) {
            Log::error('[StripeWebhook] Webhook secret missing (services.stripe.webhook_secret / STRIPE_WEBHOOK_SECRET)');
            return response()->json(['error' => 'Webhook secret not configured'], 500);
        }

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            Log::error('[StripeWebhook] Signature failed', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (UnexpectedValueException $e) {
            Log::error('[StripeWebhook] Invalid payload', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $type = $event->type ?? '';

        if ($type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            $intentId = $intent->id ?? null;

            // Metadata written by ApiController@payment()
            $appId     = $intent->metadata->application_id ?? null; // stable (my_row_id)
            $projectId = $intent->metadata->project_id ?? null;      // may be projects.id OR my_row_id
            $userId    = $intent->metadata->user_id ?? null;

            if (!$appId || !is_numeric($appId) || (int)$appId <= 0) {
                Log::warning('[StripeWebhook] Missing/invalid metadata.application_id (ignored)', [
                    'intent' => $intentId,
                    'metadata' => $intent->metadata ?? null,
                ]);
                return response()->json(['received' => true], 200);
            }

            $appIdInt = (int) $appId;

            // Find Application by my_row_id first, then legacy id (backward compat).
            $application = Application::query()
                ->select('applications.*', DB::raw('applications.my_row_id as my_row_id'))
                ->where('applications.my_row_id', $appIdInt)
                ->orWhere('applications.id', $appIdInt)
                ->first();

            if (!$application) {
                Log::warning('[StripeWebhook] Application not found (ignored)', [
                    'intent' => $intentId,
                    'application_id' => $appIdInt,
                    'project_id_meta' => $projectId,
                ]);
                return response()->json(['received' => true], 200);
            }

            // Determine project lookup id: metadata.project_id OR application->project_id
            $finalProjectLookupId = (is_numeric($projectId) && (int)$projectId > 0)
                ? (int)$projectId
                : (int)($application->project_id ?? 0);

            if ($finalProjectLookupId <= 0) {
                Log::warning('[StripeWebhook] No usable project id (ignored)', [
                    'intent' => $intentId,
                    'application_my_row_id' => $application->my_row_id ?? null,
                    'application_project_id' => $application->project_id ?? null,
                ]);
                return response()->json(['received' => true], 200);
            }

            $finalUserId = (is_numeric($userId) && (int)$userId > 0) ? (int)$userId : null;

            // Amount in dollars
            $amount = isset($intent->amount_received)
                ? ((float)$intent->amount_received / 100)
                : ((float)($intent->amount ?? 0) / 100);

            try {
                DB::transaction(function () use (
                    $intent,
                    $intentId,
                    $appIdInt,
                    $application,
                    $finalProjectLookupId,
                    $finalUserId,
                    $amount
                ) {
                    // Find project by id OR my_row_id (critical)
                    $project = Project::query()
                        ->where('id', $finalProjectLookupId)
                        ->orWhere('my_row_id', $finalProjectLookupId)
                        ->lockForUpdate()
                        ->first();

                    if (!$project) {
                        Log::warning('[StripeWebhook] Project not found (ignored)', [
                            'intent' => $intentId,
                            'project_lookup_id' => $finalProjectLookupId,
                            'application_my_row_id' => $application->my_row_id ?? null,
                        ]);
                        return;
                    }

                    // ✅ CRITICAL FIX:
                    // Do NOT exit early if payment exists. Only prevent duplicate insert.
                    $payment = Payment::where('paymentIntentId', $intentId)->first();

                    if (!$payment) {
                        // Use payer id safely: metadata user_id OR project owner
                        $payerId = $finalUserId ?: ($project->user_id ?? null);

                        Payment::create([
                            'user_id'        => $payerId,                 // no auth() in webhook
                            'application_id' => $appIdInt,                 // stable my_row_id
                            'amount'         => number_format((float)$amount, 2, '.', ''),
                            'paymentIntentId'=> $intentId,
                            'paymentStatus'  => $intent->status ?? 'succeeded',
                            'paymentDetails' => json_encode($intent),
                            'stripe_transfer_id' => null,
                        ]);
                    } else {
                        // Keep payment synced (idempotent update)
                        $payment->paymentStatus  = $intent->status ?? $payment->paymentStatus;
                        $payment->paymentDetails = json_encode($intent);
                        $payment->save();
                    }

                    // Update application status (only if not already)
                    if (($application->status ?? null) !== 'Approved') {
                        Application::where('my_row_id', $application->my_row_id)->update([
                            'status' => 'Approved',
                        ]);
                    }

                    // Update project columns (only real columns)
                    $project->payment_status = 'paid';
                    $project->status = 'in_progress';

                    // Store stable selected_application_id as my_row_id
                    $project->selected_application_id = $appIdInt;

                    $project->save();

                    // ✅ Send notifications to both parties
                    try {
                        // Notify the freelancer that their application was approved
                        Notification::create([
                            'user_id' => $application->user_id, // Freelancer
                            'title' => 'Application Approved! 🎉',
                            'message' => "Your application for \"{$project->title}\" has been approved. Payment received - you can start working on the project now!",
                        ]);

                        // Notify the client that payment succeeded  
                        Notification::create([
                            'user_id' => $project->user_id, // Client
                            'title' => 'Payment Successful',
                            'message' => "Your payment for \"{$project->title}\" was successful. The freelancer has been notified to start work.",
                        ]);
                    } catch (\Throwable $notifyError) {
                        Log::error('[StripeWebhook] Notification failed', [
                            'error' => $notifyError->getMessage(),
                            'project_id' => $project->id ?? null,
                        ]);
                    }

                    Log::info('[StripeWebhook] Updated project + application after succeeded intent', [
                        'intent' => $intentId,
                        'application_my_row_id' => $application->my_row_id ?? null,
                        'project_id' => $project->id ?? null,
                        'project_my_row_id' => $project->my_row_id ?? null,
                    ]);
                });
            } catch (\Throwable $e) {
                Log::error('[StripeWebhook] Processing failed (non-fatal, returning 200)', [
                    'intent' => $intentId,
                    'application_id' => $appIdInt,
                    'project_lookup_id' => $finalProjectLookupId,
                    'error' => $e->getMessage(),
                ]);

                // Return 200 so Stripe doesn't hammer you; you can reprocess manually if needed.
                return response()->json(['received' => true], 200);
            }

            return response()->json(['received' => true], 200);
        }

        if ($type === 'payment_intent.payment_failed') {
            $intent = $event->data->object;
            Log::warning('[StripeWebhook] Payment failed', [
                'intent' => $intent->id ?? null,
                'metadata' => $intent->metadata ?? null,
                'last_payment_error' => $intent->last_payment_error ?? null,
            ]);
            return response()->json(['received' => true], 200);
        }

        return response()->json(['received' => true], 200);
    }
}
