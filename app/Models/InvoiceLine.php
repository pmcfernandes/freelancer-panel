<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceLine extends Model
{
    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
        'vat' => 'integer'
    ];

    protected $fillable = [
        'description',
        'quantity',
        'unit_price',
        'total',
        'vat',
        'invoice_id',
    ];

    protected $appends = [
        'total_with_vat',
    ];

    public function getTotalWithVatAttribute(): float
    {
        $discount = 1 - ($this->discount / 100);
        $vat = 1 + ($this->vat / 100);
        $price_with_discount =  ($this->unit_price * $discount); // Price after discount
        $price_with_discount = $price_with_discount * $vat; // Price after VAT
        $total = $price_with_discount * $this->quantity; // Total price
        return round($total, 2);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
