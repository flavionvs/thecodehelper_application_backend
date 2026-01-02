<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Application;
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
    /**
     * IMPORTANT (Jan 2026):
     * - applications real PK is my_row_id (AUTO_INCREMENT, may be INVISIBLE)
     * - applications.id is NOT auto-increment and is often 0
     * - ApiController@payment now writes Stripe metadata.application_id as the STABLE app id (my_row_id)
     * - payments table in your app uses columns like:
     *   user_id, application_id, amount, paymentIntentId, paymentStatus, paymentDetails, stripe_transfer_id, timestamps
     */
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        if (!$secret) {
            Log::error('Stripe webhook secret missing (services.stripe.webhook_secret)');
            return response()->json(['error' => 'Webhook secret not configured'], 500);
        }

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature failed', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (UnexpectedValueException $e) {
            Log::error('Stripe webhook invalid payload', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // We care mostly about succeeded intents
        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            // Metadata written by ApiController@payment()
            $appId    = $intent->metadata->application_id ?? null; // STABLE (my_row_id)
            $projectId = $intent->metadata->project_id ?? null;
            $userId   = $intent->metadata->user_id ?? null;

            if (!$appId || !is_numeric($appId) || (int)$appId <= 0) {
                // Do NOT 400, otherwise Stripe retries forever
                Log::warning('Stripe succeeded missing/invalid application_id (ignored)', [
                    'intent' => $intent->id ?? null,
                    'metadata' => $intent->metadata ?? null,
                ]);
                return response()->json(['received' => true], 200);
            }

            // project_id is helpful but not strictly required (we can read via application)
            $appIdInt = (int)$appId;

            // Idempotency: if we already processed this PaymentIntent, return OK
            if (Payment::where('paymentIntentId', $intent->id)->exists()) {
                return response()->json(['received' => true, 'status' => 'already_processed'], 200);
            }

            // Find Application by my_row_id FIRST, then fallback to legacy id
            // Also explicitly select my_row_id (because it may be INVISIBLE).
            $application = Application::query()
                ->select('applications.*', DB::raw('applications.my_row_id as my_row_id'))
                ->where('applications.my_row_id', $appIdInt)
                ->orWhere('applications.id', $appIdInt) // backward compatibility
                ->first();

            if (!$application) {
                Log::warning('Stripe succeeded: application not found (ignored)', [
                    'intent' => $intent->id ?? null,
                    'application_id' => $appIdInt,
                    'project_id' => $projectId,
                ]);
                return response()->json(['received' => true], 200);
            }

            // Derive project_id if missing/wrong
            $finalProjectId = $projectId && is_numeric($projectId) ? (int)$projectId : (int)$application->project_id;
            if ($finalProjectId <= 0) {
                Log::warning('Stripe succeeded: application has no project_id (ignored)', [
                    'intent' => $intent->id ?? null,
                    'application_id' => $appIdInt,
                    'application_project_id' => $application->project_id ?? null,
                ]);
                return response()->json(['received' => true], 200);
            }

            // Derive user_id if missing
            $finalUserId = $userId && is_numeric($userId) ? (int)$userId : null;

            // Amount in dollars (your DB stores "1276.30" strings etc.)
            $amount = isset($intent->amount_received) ? ((float)$intent->amount_received / 100) : ((float)$intent->amount / 100);

            // Save payment + update statuses atomically
            DB::beginTransaction();
            try {
                // Create payment row in YOUR payments table format
                Payment::create([
                    'user_id'        => $finalUserId ?? auth()->id(), // if null, still store something if possible
                    // Store STABLE application identifier here (my_row_id)
                    'application_id' => $appIdInt,
                    'amount'         => number_format($amount, 2, '.', ''),
                    'paymentIntentId'=> $intent->id,
                    'paymentStatus'  => $intent->status ?? 'succeeded',
                    'paymentDetails' => json_encode($intent),
                    'stripe_transfer_id' => null,
                ]);

                // Update Application status
                // Choose your desired post-payment status; "Approved" is what your dashboard counts as in-progress.
                // If you want a distinct state, change to 'Paid' or similar.
                Application::where('my_row_id', $application->my_row_id)->update([
                    'status' => 'Approved',
                ]);

                // Update Project payment + selected app
                Project::where('id', $finalProjectId)->update([
                    'payment_status' => 'paid',
                    'status' => 'in_progress',
                    // Save stable application identifier (my_row_id) into selected_application_id
                    'selected_application_id' => $appIdInt,
                ]);

                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('Stripe succeeded processing failed', [
                    'intent' => $intent->id ?? null,
                    'application_id' => $appIdInt,
                    'project_id' => $finalProjectId,
                    'error' => $e->getMessage(),
                ]);

                // Return 200 so Stripe doesn't hammer you; you can reprocess manually if needed.
                return response()->json(['received' => true], 200);
            }

            return response()->json(['received' => true], 200);
        }

        // Optional: log failures (don’t throw)
        if ($event->type === 'payment_intent.payment_failed') {
            $intent = $event->data->object;
            Log::warning('Stripe payment failed', [
                'intent' => $intent->id ?? null,
                'metadata' => $intent->metadata ?? null,
                'last_payment_error' => $intent->last_payment_error ?? null,
            ]);
            return response()->json(['received' => true], 200);
        }

        return response()->json(['received' => true], 200);
    }
}
