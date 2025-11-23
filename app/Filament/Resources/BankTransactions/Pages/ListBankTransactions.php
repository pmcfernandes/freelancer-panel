<?php

namespace App\Filament\Resources\BankTransactions\Pages;

use App\Filament\Resources\BankTransactions\BankTransactionResource;
use App\Filament\Resources\BankTransactions\Widgets\BankTransactionWidget;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBankTransactions extends ListRecords
{
    protected static string $resource = BankTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BankTransactionWidget::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'deposit' => Tab::make('Deposit')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type','deposit')),
            'withdrawal' => Tab::make('Withdrawal')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', 'withdrawal')),
        ];
    }

    public function getDefaultActiveTab(): string
    {
        return 'all';
    }
}
