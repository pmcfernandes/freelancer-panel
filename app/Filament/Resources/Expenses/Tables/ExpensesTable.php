<?php

namespace App\Filament\Resources\Expenses\Tables;

use App\Models\Expense;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('expense_date')
                    ->label('Date')
                    ->date('d-m-Y')
                    ->sortable()
                    ->width(120),
                TextColumn::make('amount')
                    ->numeric()
                    ->money('eur', true)
                    ->sortable()
                    ->width(120),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->width(120),
                TextColumn::make('created_at')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->width(140),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('download_invoice')
                    ->label('Invoice')
                    ->url(fn (Expense $record) => route('expenses.download', ['id' => $record->id]))
                    ->visible(fn (Expense $record) => !empty($record->attachment))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
