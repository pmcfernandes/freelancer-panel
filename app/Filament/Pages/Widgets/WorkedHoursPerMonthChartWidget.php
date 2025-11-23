<?php

namespace App\Filament\Pages\Widgets;

use \App\Models\TimeRecord;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class WorkedHoursPerMonthChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Worked Hours Per Month';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'labels' => range(1, 12),
            'datasets' => $this->getDataSet(),
        ];
    }

    private function getDataSet(): array
    {
        $filterByYear = $this->pageFilters['filterByYear'] ?? now()->year;
        $months = range(1, 12);

        $workedHours = array_map(function ($month) use ($filterByYear) {
            return TimeRecord::whereYear('record_date', $filterByYear)
                ->whereMonth('record_date', $month)
                ->sum('hours');
        }, $months);

        return [
            [
                'label' => 'Worked Hours',
                'data' => $workedHours,
                'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1,
            ],
        ];
    }
}
