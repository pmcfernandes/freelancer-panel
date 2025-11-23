<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Filament\Resources\Customers\Schemas\CustomerForm;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Forms\Components\TextInput::make('description')
                    ->maxLength(20248)
                    ->columnSpanFull(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->createOptionForm(fn(Schema $schema) => CustomerForm::configure($schema))
                    ->required(),
                Forms\Components\FileUpload::make('attachment')
                    ->label('File')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
