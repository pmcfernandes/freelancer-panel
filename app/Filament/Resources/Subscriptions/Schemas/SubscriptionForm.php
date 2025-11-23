<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Filament\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Subscription Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('interval')
                    ->label('Interval')
                    ->options([
                        1 => 'Monthly',
                        2 => 'Quarterly',
                        3 => 'Yearly',
                    ])
                    ->required(),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->prefix('€')
                    ->default(0),
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required()
                    ->default(now()),
                DatePicker::make('end_date')
                    ->label('End Date'),
                Select::make('status')
                    ->label('Status')
                    ->options(SubscriptionStatus::class)
                    ->default('active')
                    ->required(),
            ]);
    }
}
