<?php

function transfer($stripe_account_id, $amount){
    try {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        if (!$stripe_account_id) {
            return ['status' => false, 'message' => 'Freelancer Stripe account ID is missing.'];
        }

        $account = \Stripe\Account::retrieve($stripe_account_id);

        if (!$account->charges_enabled || !$account->payouts_enabled) {
            return ['status' => false, 'message' => 'Freelancer Stripe account is not fully verified. Please ask them to complete Stripe onboarding.'];
        }

        $amountCents = (int) round(roundOff($amount) * 100);

        if ($amountCents <= 0) {
            return ['status' => false, 'message' => 'Transfer amount must be greater than zero.'];
        }

        // Check platform balance before attempting transfer
        $balance = \Stripe\Balance::retrieve();
        $availableUsd = collect($balance->available)->firstWhere('currency', 'usd')->amount ?? 0;

        if ($availableUsd < $amountCents) {
            \Log::warning('Insufficient platform balance for transfer', [
                'available_cents' => $availableUsd,
                'required_cents' => $amountCents,
                'destination' => $stripe_account_id,
            ]);
            return ['status' => false, 'message' => 'Insufficient platform balance to process transfer. Please contact support.'];
        }

        $transfer = \Stripe\Transfer::create([
            'amount' => $amountCents,
            'currency' => 'usd',
            'destination' => $stripe_account_id,
            'description' => 'Payment for completed project',
        ]);

        return ['status' => true, 'stripe_transfer_id' => $transfer->id, 'balance' => $availableUsd];

    } catch (\Stripe\Exception\ApiErrorException $e) {
        \Log::error('Stripe transfer API error', [
            'error' => $e->getMessage(),
            'stripe_account_id' => $stripe_account_id,
            'amount' => $amount,
        ]);
        return ['status' => false, 'message' => 'Stripe transfer failed: ' . $e->getMessage()];
    } catch (\Exception $e) {
        \Log::error('Transfer error', [
            'error' => $e->getMessage(),
            'stripe_account_id' => $stripe_account_id,
            'amount' => $amount,
        ]);
        return ['status' => false, 'message' => 'Transfer failed: ' . $e->getMessage()];
    }
}