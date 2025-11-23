<?php

namespace App\Filament\Resources\TimeRecords\Schemas;

use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Models\Project;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TimeRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->required(),
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->createOptionForm(fn(Schema $schema ) => ProjectForm::configure($schema))
                    ->required(),
                DatePicker::make('record_date')
                    ->label('Date')
                    ->required(),
                TextInput::make('hours')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Checkbox::make('billable')
                    ->default(true),
            ]);
    }
}
