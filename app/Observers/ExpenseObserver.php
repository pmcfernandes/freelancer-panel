<?php

namespace App\Observers;

use App\Filament\Enums\BankTransactionType;
use App\Filament\Enums\ExpenseStatus;
use App\Models\Expense;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ExpenseObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Expense "created" event.
     */
    public function created(Expense $expense): void
    {
        if ($expense->create_bank_transaction && $expense->status == ExpenseStatus::APPROVED) {
            if ($expense->bankTransactions()->where('type', BankTransactionType::DEPOSIT)->count() === 0) {
                $expense->bankTransactions()->create([
                    'name' => "Expense Payment: " . $expense->description,
                    'amount' => $expense->amount,
                    'type' => BankTransactionType::DEPOSIT,
                    'transaction_date' => $expense->paid_at ?? now(),
                    'company_id' => $expense->company_id,
                ]);
            }
        }
    }

    /**
     * Handle the Expense "updated" event.
     */
    public function updated(Expense $expense): void
    {
        if ($expense->create_bank_transaction && $expense->status == ExpenseStatus::APPROVED) {
            if ($expense->bankTransactions()->where('type', BankTransactionType::DEPOSIT)->count() === 0) {
                $expense->bankTransactions()->create([
                    'name' => "Expense Payment: " . $expense->description,
                    'amount' => $expense->amount,
                    'type' => BankTransactionType::DEPOSIT,
                    'transaction_date' => $expense->paid_at ?? now(),
                    'company_id' => $expense->company_id,
                ]);
            }
        }
    }

    /**
     * Handle the Expense "deleted" event.
     */
    public function deleted(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "restored" event.
     */
    public function restored(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "force deleted" event.
     */
    public function forceDeleted(Expense $expense): void
    {
        //
    }
}
