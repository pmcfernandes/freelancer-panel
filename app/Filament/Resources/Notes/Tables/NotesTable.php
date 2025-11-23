<?php

namespace App\Filament\Resources\Notes\Tables;

use App\Models\Note;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('contact.name')
                    ->getStateUsing(fn(Note $record) => "{$record->contact?->company} - {$record->contact?->name}")
                    ->sortable(),
                TextColumn::make('date')
                    ->date('d-m-Y')
                    ->sortable()
                    ->width(140),
                TextColumn::make('type')
                    ->sortable()
                    ->badge(fn($state) => $state)
                    ->width(120),
            ])
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
