<?php

namespace App\Filament\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum NoteType: string implements HasLabel, HasColor
{
    case PHONE = 'phone';
    case EMAIL = 'email';
    case MEETING = 'meeting';
    case ONLINE_MEETING = 'online-meeting';
    case CHAT = 'chat';
    case OTHER = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::PHONE => 'Phone',
            self::EMAIL => 'Email',
            self::MEETING => 'Meeting',
            self::ONLINE_MEETING => 'Online Meeting',
            self::CHAT => 'Chat',
            self::OTHER => 'Other',
        };
    }

    public function getColor(): string
    {
        return 'gray';
    }

}
