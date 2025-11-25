<?php

namespace App\Filament\Resources\Customers\Widgets;

use App\Models\Customer;
use App\Models\Project;
use App\Models\TimeRecord;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerEditWidget extends StatsOverviewWidget
{

    public ?Customer $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', $this->getTotalProjects()),
            Stat::make('Total Hours', $this->getTotalHours()),
            Stat::make('Total Won', '€' . number_format($this->getTotalWon(), 2)),
        ];
    }

    private function getTotalProjects() : int
    {
        return Project::where('customer_id', $this->record->id)->count();
    }

    private function getTotalHours() : int
    {
        return TimeRecord::with(['project'])
            ->whereHas('project', function ($query) {
                $query->where('customer_id', $this->record->id);
            })->sum('hours');
    }

    private function getTotalWon(): float
    {
        return TimeRecord::with(['project'])
            ->whereHas('project', function ($query) {
                $query->where('customer_id', $this->record->id);
            })->sum('revenue');
    }
}
