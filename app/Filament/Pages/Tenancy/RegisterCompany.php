<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Company;
use Filament\Forms;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas;
use Filament\Schemas\Schema;

class RegisterCompany extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register company';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('vat_number')
                            ->label('VAT Number')
                            ->required()
                            ->maxLength(10)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('city')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('state')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('zip')
                            ->label('ZIP / Postal Code')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\Select::make('country_id')
                            ->relationship('country', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel(),
                        Forms\Components\TextInput::make('website')
                            ->url(),
                    ]),
            ]);
    }

    protected function handleRegistration(array $data): Company
    {
        $company = Company::create($data);
        $company->users()->attach(auth()->user());

        return $company;
    }
}
