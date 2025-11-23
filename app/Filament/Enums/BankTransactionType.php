<?php

namespace App\Filament\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum BankTransactionType: string implements HasLabel, HasColor
{
    case WITHDRAWAL = 'withdrawal';
    case DEPOSIT = 'deposit';

    public function getLabel(): string
    {
        return match ($this) {
            self::WITHDRAWAL => 'Withdrawal',
            self::DEPOSIT => 'Deposit',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::WITHDRAWAL => 'danger',
            self::DEPOSIT => 'success',
        };
    }
}
