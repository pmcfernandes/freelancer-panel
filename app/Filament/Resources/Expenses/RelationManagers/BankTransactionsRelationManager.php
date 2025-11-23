<?php

namespace App\Filament\Resources\Expenses\RelationManagers;

use \App\Filament\Resources\BankTransactions\Tables\BankTransactionsTable;
use \App\Filament\Resources\BankTransactions\Schemas\BankTransactionForm;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;


class BankTransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'bankTransactions';

    public function form(Schema $schema): Schema
    {
        return BankTransactionForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return BankTransactionsTable::configureRelationManager($table);
    }
}
