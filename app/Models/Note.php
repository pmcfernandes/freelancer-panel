<?php

namespace App\Models;

use App\Filament\Enums\NoteType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $casts = [
        'type' => NoteType::class,
        'date' => 'date',
    ];

    protected $fillable = [
        'title',
        'content',
        'contact_id',
        'type',
        'date',
        'company_id',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
