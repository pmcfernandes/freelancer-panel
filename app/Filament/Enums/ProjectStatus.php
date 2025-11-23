<?php

namespace App\Filament\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProjectStatus : string  implements HasLabel, HasColor
{
    case PLANNING = 'planned';
    case  IN_PROGRESS = 'in-progress';
    case  COMPLETED = 'completed';
    case  ON_HOLD = 'on-hold';
    case  CANCELLED = 'cancelled';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::PLANNING => 'Planned',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::ON_HOLD => 'On Hold',
            self::CANCELLED => 'Cancelled',
        };
    }
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PLANNING => 'gray',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
            self::ON_HOLD => 'warning',
            self::CANCELLED => 'danger',
        };
    }
}
