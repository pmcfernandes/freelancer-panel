<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Enums\ProjectStatus;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required()
                    ->createOptionForm(fn(Schema $schema) => CustomerForm::configure($schema))
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->grow(true)
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->default(now())
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('hourly_rate')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Select::make('status')
                    ->options(ProjectStatus::class)
                    ->default('planned')
                    ->required(),
            ]);
    }
}
