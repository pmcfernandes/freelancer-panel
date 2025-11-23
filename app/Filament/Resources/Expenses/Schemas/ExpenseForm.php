<?php

namespace App\Filament\Resources\Expenses\Schemas;

use App\Filament\Enums\ExpenseStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->required(),
                DatePicker::make('expense_date')
                    ->label('Date')
                    ->required(),
                TextInput::make('amount')
                    ->label('Amount Incl vat')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('status')
                    ->options(ExpenseStatus::class)
                    ->default('pending')
                    ->required(),
                FileUpload::make('attachment')
                    ->label('Document')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
