<?php

namespace App\Models;

use App\Filament\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'hourly_rate' => 'decimal:2',
        'status' => ProjectStatus::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'hourly_rate',
        'status',
        'customer_id',
        'company_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
