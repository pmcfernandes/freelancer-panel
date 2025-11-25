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
            Stat::make('Active Subscriptions', $this->getTotalEntries()),
            Stat::make('Estimated monthly costs', '€' . number_format($this->getTotalMonthlyExpenses(), 2)),
            Stat::make('Estimated yearly costs', '€' . number_format($this->getEstimativesCostsPerYear(), 2)),
        ];
    }

    private function getTotalEntries(): int
    {
        return Subscription::where('status', 'active')->count();
    }

    private function getTotalMonthlyExpenses(): float
    {
        $monthly = Subscription::where('status', 'active')
            ->where('interval', '1')
            ->sum('price');

        $quarterly = Subscription::where('status', 'active')
            ->where('interval', '2')
            ->sum('price');

        $yearly = Subscription::where('status', 'active')
            ->where('interval', '3')
            ->sum('price');

        return $monthly + ($quarterly / 4) + ($yearly / 12);
    }

    private function getEstimativesCostsPerYear(): float
    {
        $monthly = Subscription::where('status', 'active')
            ->where('interval', '1')
            ->sum('price') * 12;

        $quarterly = Subscription::where('status', 'active')
            ->where('interval', '2')
            ->sum('price') * 4;

        $yearly = Subscription::where('status', 'active')
            ->where('interval', '3')
            ->sum('price');

        return $monthly + $quarterly + $yearly;
    }
}
