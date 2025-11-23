<?php

namespace App\Filament\Resources\BankTransactions\Schemas;

use App\Filament\Enums\BankTransactionType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BankTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->rules(['not_in:0.0']),
                Select::make('type')
                    ->options(BankTransactionType::class)
                    ->default('deposit')
                    ->required(),
                DatePicker::make('transaction_date')
                    ->required()
                    ->default(now()),
                TextInput::make('description')
                    ->maxLength(20248)
                    ->columnSpanFull(),
            ]);
    }
}
