<?php

namespace App\Models;

use App\Filament\Enums\ExpenseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'status' => ExpenseStatus::class
    ];

    protected $fillable = [
        'description',
        'expense_date',
        'amount',
        'status',
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
