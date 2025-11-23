<?php

namespace App\Models;

use App\Filament\Enums\BankTransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTransaction extends Model
{
    use SoftDeletes;

    protected $casts = [
        'type' =>  BankTransactionType::class,
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected $fillable = [
        'name',
        'description',
        'amount',
        'type',
        'transaction_date',
        'company_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function subscriptions(): MorphToMany
    {
        return $this->morphedByMany(Subscription::class, 'transactionable', 'transactions', 'transaction_id');
    }

    public function expenses(): MorphToMany
    {
        return $this->morphedByMany(Expense::class, 'transactionable', 'transactions', 'transaction_id');
    }


}
