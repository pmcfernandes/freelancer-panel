<?php

namespace App\Models;

use App\Observers\TimeRecordObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TimeRecordObserver::class])]
class TimeRecord extends Model
{
    use SoftDeletes, HasEvents;

    protected $casts = [
        'record_date' => 'datetime',
        'hours' => 'integer',
        'revenue' => 'decimal:2',
        'billable' => 'boolean',
    ];

    protected $appends = [
        'customer',
    ];

    protected $fillable = [
        'description',
        'record_date',
        'hours',
        'billable',
        'revenue',
        'project_id',
        'company_id',
    ];

    public function getCustomerAttribute(): string|null
    {
        return $this->project->customer->name ?? null;
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
