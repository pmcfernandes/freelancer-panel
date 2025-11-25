<?php

namespace App\Jobs;

use App\Filament\Enums\BankTransactionType;
use App\Filament\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use \Carbon\Carbon;

class SubcriptionBankTransactionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly ?Subscription $subscription = null)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check for subscriptions with ACTIVE status
        $subscriptions = Subscription::where('status', SubscriptionStatus::ACTIVE)->get();

        foreach ($subscriptions as $subscription) {
            $date = Carbon::parse($subscription->start_date);

            switch ($subscription->interval) {
                case 1: // Monthly, Add one month and one day
                    $dateToCompare = $date->copy()->addMonth()->addDay(1);
                    break;
                case 2: // Quarterly, Add three months and one day
                    $dateToCompare = $date->copy()->addMonths(3)->addDay(1);
                    break;
                case 3: // Yearly, Add one year and one day
                    $dateToCompare = $date->copy()->addYear()->addDay(1);
                    break;
                default:
                    continue 2;
            }

            // Check if start_date is today; skip if not
            if ($date->isToday() || $dateToCompare->isToday()) {
                if ($this->subscription == null || $this->subscription->id === $subscription->id) {
                    $exists = $subscription->bankTransactions()
                        ->where('type', BankTransactionType::WITHDRAWAL)
                        ->whereDate('transaction_date', Carbon::today())
                        ->exists();

                    if ($exists) {
                        continue;
                    }

                    $subscription->bankTransactions()->create([
                        'transaction_date' => now(),
                        'amount' => $subscription->price ?? 0,
                        'name' => "Payment for Subscription: " . $subscription->name,
                        'type' => BankTransactionType::WITHDRAWAL,
                        'company_id' => $subscription->company_id,
                    ]);
                }
            }
        }
    }
}
