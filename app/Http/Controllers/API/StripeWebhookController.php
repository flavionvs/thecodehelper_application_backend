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
            $appId     = $intent->metadata->application_id ?? null; // stable (id)
            $projectId = $intent->metadata->project_id ?? null;      // may be projects.id OR id
            $userId    = $intent->metadata->user_id ?? null;

            if (!$appId || !is_numeric($appId) || (int)$appId <= 0) {
                Log::warning('[StripeWebhook] Missing/invalid metadata.application_id (ignored)', [
                    'intent' => $intentId,
                    'metadata' => $intent->metadata ?? null,
                ]);
                return response()->json(['received' => true], 200);
            }

            $appIdInt = (int) $appId;

            // Find Application by id
            $application = Application::find($appIdInt);

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
                    'application_id' => $application->id ?? null,
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
                    // Find project by id
                    $project = Project::where('id', $finalProjectLookupId)
                        ->lockForUpdate()
                        ->first();

                    if (!$project) {
                        Log::warning('[StripeWebhook] Project not found (ignored)', [
                            'intent' => $intentId,
                            'project_lookup_id' => $finalProjectLookupId,
                            'application_id' => $application->id ?? null,
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
                            'application_id' => $appIdInt,                 // stable id
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
                        Application::where('id', $application->id)->update([
                            'status' => 'Approved',
                        ]);
                    }

                    // Update project columns (only real columns)
                    $alreadyPaid = ($project->payment_status === 'paid');
                    $project->payment_status = 'paid';
                    $project->status = 'in_progress';

                    // Store stable selected_application_id as id
                    $project->selected_application_id = $appIdInt;

                    $project->save();

                    // ✅ Send notifications to both parties (skip if already sent by payment())
                    if (!$alreadyPaid) {
                        try {
                            // Notify the freelancer that their application was approved
                            Notification::create([
                                'user_id' => $application->user_id, // Freelancer
                                'title' => 'Application Approved! 🎉',
                                'message' => "Your application for \"{$project->title}\" has been approved. Payment received - you can start working on the project now!",
                                'type' => 'approved',
                                'link' => '/user/project?type=ongoing',
                                'reference_id' => $project->id,
                            ]);

                            // Notify the client that payment succeeded  
                            Notification::create([
                                'user_id' => $project->user_id, // Client
                                'title' => 'Payment Successful',
                                'message' => "Your payment for \"{$project->title}\" was successful. The freelancer has been notified to start work.",
                                'type' => 'payment',
                                'link' => '/user/project?type=ongoing',
                                'reference_id' => $project->id,
                            ]);
                        } catch (\Throwable $notifyError) {
                            Log::error('[StripeWebhook] Notification failed', [
                                'error' => $notifyError->getMessage(),
                                'project_id' => $project->id ?? null,
                            ]);
                        }
                    }

                    Log::info('[StripeWebhook] Updated project + application after succeeded intent', [
                        'intent' => $intentId,
                        'application_id' => $application->id ?? null,
                        'project_id' => $project->id ?? null,
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

        // ✅ Handle Stripe Checkout Session completed (hosted payment page)
        if ($type === 'checkout.session.completed') {
            $session = $event->data->object;
            $sessionId = $session->id ?? null;

            $appId     = $session->metadata->application_id ?? null;
            $projectId = $session->metadata->project_id ?? null;
            $userId    = $session->metadata->user_id ?? null;

            Log::info('[StripeWebhook] checkout.session.completed', [
                'session_id' => $sessionId,
                'application_id' => $appId,
                'project_id' => $projectId,
                'payment_status' => $session->payment_status ?? null,
            ]);

            if (!$appId || !is_numeric($appId) || (int)$appId <= 0) {
                Log::warning('[StripeWebhook] Checkout session missing application_id', [
                    'session_id' => $sessionId,
                    'metadata' => $session->metadata ?? null,
                ]);
                return response()->json(['received' => true], 200);
            }

            if (($session->payment_status ?? '') !== 'paid') {
                Log::info('[StripeWebhook] Checkout session not paid yet', [
                    'session_id' => $sessionId,
                    'payment_status' => $session->payment_status ?? null,
                ]);
                return response()->json(['received' => true], 200);
            }

            $appIdInt = (int) $appId;
            $application = Application::find($appIdInt);

            if (!$application) {
                Log::warning('[StripeWebhook] Checkout: Application not found', [
                    'session_id' => $sessionId,
                    'application_id' => $appIdInt,
                ]);
                return response()->json(['received' => true], 200);
            }

            $finalProjectId = (is_numeric($projectId) && (int)$projectId > 0)
                ? (int)$projectId
                : (int)($application->project_id ?? 0);

            if ($finalProjectId <= 0) {
                Log::warning('[StripeWebhook] Checkout: No usable project id', [
                    'session_id' => $sessionId,
                    'application_id' => $appIdInt,
                ]);
                return response()->json(['received' => true], 200);
            }

            $finalUserId = (is_numeric($userId) && (int)$userId > 0) ? (int)$userId : null;

            // Amount in dollars
            $amount = isset($session->amount_total)
                ? ((float)$session->amount_total / 100)
                : 0;

            // Get the PaymentIntent ID from the session
            $intentId = $session->payment_intent ?? $sessionId;

            try {
                DB::transaction(function () use (
                    $session,
                    $intentId,
                    $sessionId,
                    $appIdInt,
                    $application,
                    $finalProjectId,
                    $finalUserId,
                    $amount
                ) {
                    $project = Project::where('id', $finalProjectId)
                        ->lockForUpdate()
                        ->first();

                    if (!$project) {
                        Log::warning('[StripeWebhook] Checkout: Project not found', [
                            'session_id' => $sessionId,
                            'project_id' => $finalProjectId,
                        ]);
                        return;
                    }

                    // Idempotent payment insert
                    $payment = Payment::where('paymentIntentId', $intentId)->first();
                    if (!$payment) {
                        $payerId = $finalUserId ?: ($project->user_id ?? null);
                        Payment::create([
                            'user_id'        => $payerId,
                            'application_id' => $appIdInt,
                            'amount'         => number_format((float)$amount, 2, '.', ''),
                            'paymentIntentId'=> $intentId,
                            'paymentStatus'  => 'succeeded',
                            'paymentDetails' => json_encode($session),
                            'stripe_transfer_id' => null,
                        ]);
                    }

                    // Update application status
                    if (($application->status ?? null) !== 'Approved') {
                        Application::where('id', $application->id)->update([
                            'status' => 'Approved',
                        ]);
                    }

                    // Update project
                    $alreadyPaid = ($project->payment_status === 'paid');
                    $project->payment_status = 'paid';
                    $project->status = 'in_progress';
                    $project->selected_application_id = $appIdInt;
                    $project->save();

                    // Notifications (skip if already sent)
                    if (!$alreadyPaid) {
                        try {
                            Notification::create([
                                'user_id' => $application->user_id,
                                'title' => 'Application Approved! 🎉',
                                'message' => "Your application for \"{$project->title}\" has been approved. Payment received - you can start working on the project now!",
                                'type' => 'approved',
                                'link' => '/user/project?type=ongoing',
                                'reference_id' => $project->id,
                            ]);
                            Notification::create([
                                'user_id' => $project->user_id,
                                'title' => 'Payment Successful',
                                'message' => "Your payment for \"{$project->title}\" was successful. The freelancer has been notified to start work.",
                                'type' => 'payment',
                                'link' => '/user/project?type=ongoing',
                                'reference_id' => $project->id,
                            ]);
                        } catch (\Throwable $e) {
                            Log::error('[StripeWebhook] Checkout notification failed', ['error' => $e->getMessage()]);
                        }
                    }

                    Log::info('[StripeWebhook] Checkout: project finalized', [
                        'session_id' => $sessionId,
                        'application_id' => $appIdInt,
                        'project_id' => $project->id,
                    ]);
                });
            } catch (\Throwable $e) {
                Log::error('[StripeWebhook] Checkout processing failed', [
                    'session_id' => $sessionId,
                    'error' => $e->getMessage(),
                ]);
            }

            return response()->json(['received' => true], 200);
        }

        return response()->json(['received' => true], 200);
    }
}
