<?php

namespace App\Filament\Resources\Mileages\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MileageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('start_location')
                    ->required(),
                TextInput::make('end_location')
                    ->required(),
                TextInput::make('distance')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->rules(['min:1']),
                TextInput::make('rate_per_km')
                    ->required()
                    ->numeric()
                    ->default(0.4),
            ]);
    }
}
