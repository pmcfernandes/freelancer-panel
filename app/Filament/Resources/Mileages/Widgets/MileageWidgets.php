<?php

namespace App\Filament\Resources\Mileages\Widgets;

use App\Models\Mileage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MileageWidgets extends StatsOverviewWidget
{

    public function getStats(): array
    {
        return [
            Stat::make('Rides', $this->getTotalEntries()),
            Stat::make('Distance this year (km)', number_format($this->getTotalDistanceThisYear(), 2)),
            Stat::make('Compensation this year (€)', '€' . number_format($this->getTotalCostsThisYear(), 2)),
        ];
    }

    private function getTotalEntries(): int
    {
        return Mileage::count();
    }

    private function getTotalDistanceThisYear(): int
    {
        $year = now()->year;
        return Mileage::whereYear('date', $year)->sum('distance');
    }

    private function getTotalCostsThisYear(): float
    {
        $year = now()->year;

        return Mileage::whereYear('date', $year)->get()->sum(function ($mileage) {
            return $mileage->distance * $mileage->rate_per_km;
        });
    }


}


