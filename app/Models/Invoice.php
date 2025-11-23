<?php

namespace App\Models;

use App\Filament\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'status' => InvoiceStatus::class,
        'payment_terms' => 'integer',
        'discount' => 'integer',
        'shipping_costs' => 'decimal:2',
    ];

    protected $appends = [
        'total'
    ];

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'total_amount',
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
}
