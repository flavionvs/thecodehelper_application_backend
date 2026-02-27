<?php

/**
 * Transfer funds to a connected Stripe account.
 *
 * @param string $stripe_account_id  The connected account ID (acct_xxx)
 * @param float  $amount             Amount in dollars
 * @param string|null $sourceTransaction  Optional charge ID (ch_xxx) to link the transfer to.
 *                                        When provided, Stripe buffers the transfer until the
 *                                        charge's funds are available — eliminates "insufficient
 *                                        platform balance" errors for recent payments.
 * @return array
 */
function transfer($stripe_account_id, $amount, $sourceTransaction = null){
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

        $transferData = [
            'amount' => $amountCents,
            'currency' => 'usd',
            'destination' => $stripe_account_id,
            'description' => 'Payment for completed project',
        ];

        // Link to the original charge so Stripe automatically waits for funds to settle.
        // This avoids "insufficient platform balance" errors for recently-captured payments.
        if ($sourceTransaction) {
            $transferData['source_transaction'] = $sourceTransaction;
            \Log::info('Transfer linked to source_transaction', [
                'charge' => $sourceTransaction,
                'destination' => $stripe_account_id,
                'amount_cents' => $amountCents,
            ]);
        } else {
            // No source_transaction — log a warning and check balance as a safety net
            $balance = \Stripe\Balance::retrieve();
            $availableUsd = collect($balance->available)->firstWhere('currency', 'usd')->amount ?? 0;

            \Log::info('Transfer without source_transaction', [
                'available_cents' => $availableUsd,
                'required_cents' => $amountCents,
                'destination' => $stripe_account_id,
            ]);

            if ($availableUsd < $amountCents) {
                \Log::warning('Low platform balance — attempting transfer anyway', [
                    'available_cents' => $availableUsd,
                    'required_cents' => $amountCents,
                ]);
            }
        }

        $transfer = \Stripe\Transfer::create($transferData);

        return ['status' => true, 'stripe_transfer_id' => $transfer->id];

    } catch (\Stripe\Exception\ApiErrorException $e) {
        \Log::error('Stripe transfer API error', [
            'error' => $e->getMessage(),
            'stripe_account_id' => $stripe_account_id,
            'amount' => $amount,
            'source_transaction' => $sourceTransaction,
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