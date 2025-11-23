<?php

namespace App\Filament\Resources\Notes\Schemas;

use App\Filament\Enums\NoteType;
use App\Filament\Resources\Contacts\Schemas\ContactForm;
use App\Models\Contact;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Select::make('contact_id')
                    ->label('Contact')
                    ->options(Contact::selectRaw("CONCAT(company, ' - ', name) as label, id")->pluck('label', 'id'))
                    ->createOptionForm(fn(Schema $schema) => ContactForm::configure($schema)->columns(2))
                    ->required(),
                Textarea::make('content')
                    ->rows(4)
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(NoteType::class)
                    ->default('other')
                    ->required(),
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
            ]);
    }
}
