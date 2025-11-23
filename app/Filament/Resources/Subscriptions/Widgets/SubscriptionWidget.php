<?php

namespace App\Filament\Resources\Subscriptions\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use \App\Models\Subscription;

class SubscriptionWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Subscriptions', $this->getTotalEntries()),
            Stat::make('Estimated monthly costs', '€' . number_format($this->getTotalMonthlyExpenses(), 2)),
            Stat::make('Estimated yearly costs', '€' . number_format($this->getEstimativesCostsPerYear(), 2)),
        ];
    }

    private function getTotalEntries(): int
    {
        return Subscription::count();
    }

    private function getTotalMonthlyExpenses(): float
    {
        $year = now()->year;

        $monthly = Subscription::where('interval', '1')
            ->whereYear('created_at', $year)
            ->sum('price');

        $quartely = Subscription::where('interval', '2')
            ->whereYear('created_at', $year)
            ->sum('price');

        $yearly = Subscription::where('interval', '3')
            ->whereYear('created_at', $year)
            ->sum('price');

        return $monthly + ($quartely / 4) + ($yearly / 12);
    }

    private function getEstimativesCostsPerYear(): float
    {
        $year = now()->year;

        $monthly = Subscription::where('interval', '1')
            ->whereYear('created_at', $year)
            ->sum('price') * 12;

        $quartely = Subscription::where('interval', '2')
            ->whereYear('created_at', $year)
            ->sum('price') * 4;

        $yearly = Subscription::where('interval', '3')
            ->whereYear('created_at', $year)
            ->sum('price');

        return $monthly + $quartely + $yearly;
    }
}
