<?php

namespace App\Models;

use App\Filament\Enums\ExpenseStatus;
use App\Observers\ExpenseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ExpenseObserver::class])]
class Expense extends Model
{
    use SoftDeletes;

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'status' => ExpenseStatus::class,
        'paid_at' => 'date',
        'create_bank_transaction' => 'boolean'
    ];

    protected $fillable = [
        'description',
        'expense_date',
        'amount',
        'status',
        'paid_at',
        'create_bank_transaction',
        'attachment',
        'company_id',
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
