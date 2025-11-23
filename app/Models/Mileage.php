<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mileage extends Model
{
    use SoftDeletes;

    protected $casts = [
        'date' => 'date',
        'distance' => 'float',
        'rate_per_km' => 'float',
    ];

    protected $fillable = [
        'date',
        'description',
        'start_location',
        'end_location',
        'distance',
        'rate_per_km',
        'company_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
