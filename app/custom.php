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

        // Detect the correct currency from the source charge's balance transaction.
        // Stripe settles charges in the platform's default currency (e.g. NZD),
        // even if the charge was presented in USD. The transfer currency MUST match
        // the settlement currency, not the presentment currency.
        $currency = null;

        if ($sourceTransaction) {
            try {
                $charge = \Stripe\Charge::retrieve($sourceTransaction);
                if ($charge->balance_transaction) {
                    $bt = \Stripe\BalanceTransaction::retrieve($charge->balance_transaction);
                    $currency = $bt->currency; // e.g. 'nzd'
                    \Log::info('Detected settlement currency from balance transaction', [
                        'charge' => $sourceTransaction,
                        'balance_transaction' => $charge->balance_transaction,
                        'currency' => $currency,
                    ]);

                    // Recalculate amount in settlement currency if different from presentment
                    if ($currency !== $charge->currency && $bt->exchange_rate) {
                        $amountCents = (int) round($amountCents * $bt->exchange_rate);
                        \Log::info('Converted transfer amount to settlement currency', [
                            'original_currency' => $charge->currency,
                            'settlement_currency' => $currency,
                            'exchange_rate' => $bt->exchange_rate,
                            'converted_amount_cents' => $amountCents,
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('Could not detect settlement currency from charge', [
                    'charge' => $sourceTransaction,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Fallback: use the platform account's default currency
        if (!$currency) {
            try {
                $platformAccount = \Stripe\Account::retrieve();
                $currency = $platformAccount->default_currency ?? 'usd';
                \Log::info('Using platform default currency', ['currency' => $currency]);
            } catch (\Throwable $e) {
                $currency = 'usd';
                \Log::warning('Could not retrieve platform currency, defaulting to usd');
            }
        }

        $transferData = [
            'amount' => $amountCents,
            'currency' => $currency,
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
                'currency' => $currency,
            ]);
        } else {
            // No source_transaction — log a warning and check balance as a safety net
            $balance = \Stripe\Balance::retrieve();
            $available = collect($balance->available)->firstWhere('currency', $currency)->amount ?? 0;

            \Log::info('Transfer without source_transaction', [
                'available_cents' => $available,
                'required_cents' => $amountCents,
                'currency' => $currency,
                'destination' => $stripe_account_id,
            ]);

            if ($available < $amountCents) {
                \Log::warning('Low platform balance — attempting transfer anyway', [
                    'available_cents' => $available,
                    'required_cents' => $amountCents,
                ]);
            }
        }

        $transfer = \Stripe\Transfer::create($transferData);

        return [
            'status' => true,
            'stripe_transfer_id' => $transfer->id,
        ];

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