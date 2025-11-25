<?php

namespace App\Filament\Resources\BankTransactions\Tables;

use App\Filament\Enums\BankTransactionType;
use App\Models\BankTransaction;
use Filament\Actions\ActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Query\Builder;

class BankTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->description(fn (BankTransaction $record) => $record->description),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->suffix('€')
                    ->width(120)
                    ->color(fn(BankTransaction $record): string => $record->type->getColor()),
                TextColumn::make('transaction_date')
                    ->label('Date')
                    ->date('d-m-Y')
                    ->sortable()
                    ->width(120),
            ])
            ->defaultSort('transaction_date', 'desc')
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

    public static function configureRelationManager(Table $table): Table
    {
        return $table
            ->recordTitle(function(BankTransaction $record) {
                $date = $record->transaction_date ? $record->transaction_date->format('d-m-Y') : 'N/A';
                return "{$date} - {$record->name} ({$record->amount}€)";
            })
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->description(fn (BankTransaction $record) => $record->description),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->suffix('€')
                    ->color(fn(BankTransaction $record): string => $record->type->getColor())
                    ->width(120),
                TextColumn::make('transaction_date')
                    ->label('Date')
                    ->date('d-m-Y')
                    ->sortable()
                    ->width(120),
            ])
            ->defaultSort('transaction_date', 'desc')
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->recordSelectSearchColumns(['name', 'description'])
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ])->iconButton(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
