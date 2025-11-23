<?php

namespace App\Filament\Resources\BankTransactions\Widgets;

use App\Models\BankTransaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BankTransactionWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transactions', $this->getTotalTransactions()),
            Stat::make('Incoming', '€' . number_format($this->getIncomingValues(), 2)),
            Stat::make('Outgoing', '€' . number_format($this->getOutgoingValues(), 2)),
        ];
    }

    private function getTotalTransactions(): int
    {
        return BankTransaction::count();
    }

    private function getIncomingValues(): float
    {
        return BankTransaction::where('type', 'deposit')->sum('amount');
    }

    private function getOutgoingValues(): float
    {
        return  BankTransaction::where('type', 'withdrawal')->sum('amount');
    }
}
