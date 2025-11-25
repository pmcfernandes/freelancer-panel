<?php

namespace App\Observers;

use App\Filament\Enums\BankTransactionType;
use App\Filament\Enums\SubscriptionStatus;
use App\Jobs\SubcriptionBankTransactionJob;
use App\Models\Subscription;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class SubscriptionObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        SubcriptionBankTransactionJob::dispatchSync($subscription);
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        SubcriptionBankTransactionJob::dispatchSync($subscription);
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        //
    }
}
