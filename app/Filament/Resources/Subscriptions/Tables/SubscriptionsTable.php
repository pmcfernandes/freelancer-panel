<?php

namespace App\Filament\Resources\Subscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Subscription Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('interval')
                    ->label('Interval')
                    ->formatStateUsing(function($state) {
                        switch ($state) {
                            case 1:
                                return 'Monthly';
                            case 2:
                                return 'Quarterly';
                            case 3:
                                return 'Yearly';
                            default:
                                return "";
                        }
                    })
                    ->searchable()
                    ->sortable()
                    ->width(120),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('eur', true)
                    ->searchable()
                    ->sortable()
                    ->width(120),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->width(120),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('d-m-Y')
                    ->searchable()
                    ->sortable()
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
