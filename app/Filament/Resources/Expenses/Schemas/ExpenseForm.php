<?php

namespace App\Filament\Resources\Expenses\Schemas;

use App\Filament\Enums\ExpenseStatus;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(4)
            ->components([
                Section::make('Expense Details')
                    ->schema([
                        DatePicker::make('expense_date')
                            ->label('Date')
                            ->required(),
                        TextInput::make('amount')
                            ->label('Amount Incl vat')
                            ->required()
                            ->numeric()
                            ->default(0.0)
                            ->rules(['min:1']),
                        TextInput::make('description')
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('attachment')
                            ->label('Document')
                            ->required()
                            ->downloadable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(3),
                Section::make('Status Information')
                    ->schema([
                        Select::make('status')
                            ->options(ExpenseStatus::class)
                            ->live()
                            ->required()
                            ->default('pending'),
                        DatePicker::make('paid_at')
                            ->label('Paid At')
                            ->visible(fn (Get $get) => $get('status') === ExpenseStatus::APPROVED)
                            ->required(fn (Get $get) => $get('status') === ExpenseStatus::APPROVED),
                        Checkbox::make('create_bank_transaction')
                            ->label('Create Bank Transaction upon Payment')
                            ->visible(fn (Get $get) => $get('status') === ExpenseStatus::APPROVED)
                            ->default(false),
                    ])
                    ->columns(1)
                    ->columnSpan(1),
            ]);
    }
}
