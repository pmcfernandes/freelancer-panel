<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Filament\Enums\BankTransactionType;
use App\Filament\Enums\InvoiceStatus;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class InvoiceObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        Invoice::find($invoice->id)->update([
            'total_amount' => $invoice->total
        ]);

        if ($invoice->create_bank_transaction && $invoice->status === InvoiceStatus::PAID) {
            if ($invoice->bankTransactions()->where('type', BankTransactionType::DEPOSIT)->count() === 0) {
                $invoice->bankTransactions()->create([
                    'name' => "Payment for Invoice #" . $invoice->invoice_number,
                    'amount' => $invoice->total_amount,
                    'type' => BankTransactionType::DEPOSIT,
                    'transaction_date' => $invoice->paid_at ?? now(),
                    'company_id' => $invoice->company_id,
                ]);
            }
        }
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        Invoice::find($invoice->id)->update([
            'total_amount' => $invoice->total
        ]);

        if ($invoice->create_bank_transaction && $invoice->status === InvoiceStatus::PAID) {
            if ($invoice->bankTransactions()->where('type', BankTransactionType::DEPOSIT)->count() === 0) {
                $invoice->bankTransactions()->create([
                    'name' => "Payment for Invoice #" . $invoice->invoice_number,
                    'amount' => $invoice->total_amount,
                    'type' => BankTransactionType::DEPOSIT,
                    'transaction_date' => $invoice->paid_at ?? now(),
                    'company_id' => $invoice->company_id,
                ]);
            }
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}
