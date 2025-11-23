<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Models\Contact;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->searchable()
                            ->weight(FontWeight::Bold),
                        Tables\Columns\TextColumn::make('role')
                            ->searchable(),
                    ])->space(1),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('email')
                            ->label('Email address')
                            ->icon('heroicon-m-envelope')
                            ->searchable()
                            ->grow(false),
                        Tables\Columns\TextColumn::make('phone')
                            ->searchable()
                            ->icon('heroicon-m-phone')
                            ->grow(false),

                    ])
                        ->alignment(Alignment::End)
                        ->space(1)
                ])
            ])
            ->groups([
                Tables\Grouping\Group::make('company.name')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn(Contact $record): string => $record->company ?? 'Sem cliente'),
            ])
            ->groupingSettingsHidden()
            ->defaultGroup('company')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
