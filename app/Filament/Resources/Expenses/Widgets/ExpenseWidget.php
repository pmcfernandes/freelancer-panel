<?php

namespace App\Filament\Resources\Expenses\Widgets;

use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExpenseWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total', $this->getTotalExpenses()),
            Stat::make('Pending', '€' . number_format($this->getPendingExpenses(), 2)),
            Stat::make('Expenses', '€' . number_format($this->getExpenses(), 2)),
        ];
    }

    private function getTotalExpenses(): int
    {
        return Expense::count();
    }

    private function getPendingExpenses(): float
    {
        return Expense::where('status', 'pending')->sum('amount');
    }

    private function getExpenses(): float
    {
        return Expense::sum('amount');
    }
}
