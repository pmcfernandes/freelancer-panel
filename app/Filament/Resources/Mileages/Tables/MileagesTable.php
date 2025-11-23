<?php

namespace App\Filament\Resources\Mileages\Tables;

use App\Models\Mileage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MileagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date('d-m-Y')
                    ->sortable()
                    ->searchable()
                    ->width(120),
                TextColumn::make('start_location')
                    ->label('From -> To Location')
                    ->formatStateUsing(fn(Mileage $record) => $record->start_location . ' -> ' . $record->end_location)
                    ->searchable(),
                TextColumn::make('distance')
                    ->formatStateUsing(fn($state) => "{$state} km")
                    ->sortable()
                    ->width(140),
                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->getStateUsing(fn(Mileage $record) => number_format($record->distance * $record->rate_per_km, 2) . ' €')
                    ->alignRight()
                    ->numeric()
                    ->sortable()
                    ->width(120),
                TextColumn::make('created_at')
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
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
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
