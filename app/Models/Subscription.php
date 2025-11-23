<?php

namespace App\Models;

use App\Filament\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $casts = [
        'interval' => 'integer',
        'price' => 'decimal:2',
        'status' => SubscriptionStatus::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'interval',
        'price',
        'status',
        'start_date',
        'end_date',
        'company_id'
    ];

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
