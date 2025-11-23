<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeRecord extends Model
{
    use SoftDeletes;

    protected $casts = [
        'record_date' => 'datetime',
        'hours' => 'integer',
        'billable' => 'boolean',
        'revenue' => 'decimal:2',
    ];

    protected $appends = [
        'customer',
        'revenue'
    ];

    protected $fillable = [
        'description',
        'record_date',
        'hours',
        'billable',
        'project_id',
        'company_id',
    ];

    public function getCustomerAttribute(): string|null
    {
        return $this->project->customer->name ?? null;
    }

    public function getRevenueAttribute(): float|null
    {
        $hourly_rate = $this->project->hourly_rate ?? 0;
        return $this->hours * $hourly_rate;
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
