<?php

namespace App\Filament\Resources\TimeRecords\Widgets;

use App\Models\TimeRecord;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TimeRecordWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Entries', $this->getTotalEntries()),
            Stat::make('Hours', number_format($this->getTotalHours(), 2)),
            Stat::make('Revenue', '€' . number_format($this->getRevenue(), 2)),
        ];
    }

    private function getTotalEntries(): int
    {
        return TimeRecord::count();
    }

    private function getTotalHours(): float
    {
        return TimeRecord::sum('hours');
    }

    private function getRevenue(): float
    {
        $total = TimeRecord::all()->reduce(function ($gain, TimeRecord $timeRecord) {
            return $gain + $timeRecord->revenue;
        });

        return (float)$total;
    }


}
