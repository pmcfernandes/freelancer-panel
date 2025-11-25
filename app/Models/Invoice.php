<?php

namespace App\Models;

use App\Filament\Enums\InvoiceStatus;
use App\Observers\InvoiceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([InvoiceObserver::class])]
class Invoice extends Model
{
    use SoftDeletes;

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'status' => InvoiceStatus::class,
        'payment_terms' => 'integer',
        'discount' => 'decimal:2',
        'shipping_costs' => 'decimal:2',
        'paid_at' => 'date',
        'create_bank_transaction' => 'boolean'
    ];

    protected $appends = [
        'total'
    ];

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'paid_at',
        'total_amount',
        'create_bank_transaction',
        'status',
        'payment_terms',
        'discount',
        'shipping_costs',
        'company_id',
    ];

    public function getTotalAttribute(): float
    {
        $total = $this->lines->sum(fn ($line) => $line->total_with_vat);
        $total += $this->shipping_costs;
        return round($total, 2);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function bankTransactions(): MorphToMany
    {
        return $this->morphToMany(
            BankTransaction::class,
            'transactionable',
            'transactions',
            'transactionable_id',
            'transaction_id'
        );
    }
}
