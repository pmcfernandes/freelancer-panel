<?php

namespace App\Filament\Pages\Widgets;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\TimeRecord;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardWidgets extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    public function getStats(): array
    {
        $filterByYear = $this->pageFilters['filterByYear'] ?? now()->year;

        return [
            Stat::make('Hours worked', $this->getTotalWorkedHours($filterByYear))
                ->icon('heroicon-o-clock'),
            Stat::make('Open invoices', $this->getOpenInvoicesCount($filterByYear)),
            Stat::make('Active subscriptions', $this->getActiveSubcriptions($filterByYear)),
        ];
    }

    private function getTotalWorkedHours(int $filterByYear): string
    {
        $totalHours = TimeRecord::whereYear('record_date', $filterByYear)->get()
            ->reduce(function ($carry, $item) {
                return $carry + $item->hours;
            }, 0);


        return sprintf('%d hours', $totalHours);
    }

    private function getOpenInvoicesCount(int $filterByYear): int
    {
        $invoices = Invoice::whereIn('status', ['sent'])
            ->whereYear('created_at', '>=', $filterByYear);
        return $invoices->count();
    }

    private function getActiveSubcriptions(int $filterByYear): int
    {
        // Active subscriptions are those with status 'active' and $filterByYear is between start_date and end_date
        $subscriptions = Subscription::where('status', 'active')
            ->whereYear('start_date', '<=', $filterByYear)
            ->where(function ($query) use ($filterByYear) {
                $query->whereNull('end_date')
                      ->orWhereYear('end_date', '>=', $filterByYear);
            });
        return $subscriptions->count();
    }
}
