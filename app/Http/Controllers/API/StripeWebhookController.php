<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature failed');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            $projectId = $intent->metadata->project_id ?? null;

            if (!$projectId) {
                Log::error('Stripe payment missing project_id', ['intent' => $intent->id]);
                return response()->json(['error' => 'Missing project_id'], 400);
            }

            // Prevent duplicate processing
            if (Payment::where('stripe_payment_intent_id', $intent->id)->exists()) {
                return response()->json(['status' => 'already processed']);
            }

            Payment::create([
                'project_id' => $projectId,
                'amount' => $intent->amount_received / 100,
                'currency' => $intent->currency,
                'status' => 'paid',
                'stripe_payment_intent_id' => $intent->id,
            ]);

            Project::where('id', $projectId)->update([
                'payment_status' => 'paid',
                'status' => 'in_progress', // adjust if needed
            ]);
        }

        return response()->json(['received' => true]);
    }
}
