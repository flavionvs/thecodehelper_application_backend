<?php

function transfer($stripe_account_id, $amount){
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $account = \Stripe\Account::retrieve($stripe_account_id);
        
    
    if (!$stripe_account_id || !$account->charges_enabled || !$account->payouts_enabled) {
        return ['status' => false, 'message' => 'Freelancer Stripe account is not fully verified.'];
    }

    $balance = \Stripe\Balance::retrieve();
    foreach ($balance->available as $availableBalance) {
        // echo 'Available: ' . $availableBalance->amount . ' ' . $availableBalance->currency . PHP_EOL;
    }
    foreach ($balance->pending as $pendingBalance) {
        // echo 'Pending: ' . $pendingBalance->amount . ' ' . $pendingBalance->currency . PHP_EOL;
    }
    
    
    // $requiredAmount = $application->amount * 100; // in cents
    $availableUsd = collect($balance->available)->firstWhere('currency', 'usd')->amount ?? 0;
    
    
    $transfer = \Stripe\Transfer::create([
        'amount' => roundOff($amount) * 100,
        // 'amount' => 1 * 100, // $2 to freelancer (in cents)
        'currency' => 'nzd',
        'destination' => $stripe_account_id,
        'description' => 'Payment for completed project #1234',
    ]);    
    return ['status' => true, 'stripe_transfer_id' => $transfer->id, 'balance' => $availableUsd];

}