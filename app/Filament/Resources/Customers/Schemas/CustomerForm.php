<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Section::make('General information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('vat_number'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('address')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('city'),
                        Forms\Components\TextInput::make('zip')
                            ->label('ZIP / Postal Code'),
                        Forms\Components\Select::make('country_id')
                            ->relationship('country', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->default(null),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->columnSpanFull()
                    ])->columnSpanFull(),
                Schemas\Components\Section::make('Registration details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('iban')
                            ->label('IBAN'),
                    ])->columnSpanFull(),
            ]);
    }
}
