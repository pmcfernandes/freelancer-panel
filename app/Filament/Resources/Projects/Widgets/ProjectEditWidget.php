<?php

namespace App\Filament\Resources\Projects\Widgets;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use App\Models\TimeRecord;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectEditWidget extends StatsOverviewWidget
{

    public ?Project $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Tasks', $this->getTotalTasks()),
            Stat::make('Total Hours', $this->getTotalHours()),
            Stat::make('Total Won', '€' . number_format($this->getTotalWon(), 2)),
        ];
    }

    private function getTotalTasks() : int
    {
        return TimeRecord::where('project_id', $this->record->id)->count();
    }

    private function getTotalHours() : int
    {
        return TimeRecord::where('project_id', $this->record->id)->sum('hours');
    }

    private function getTotalWon(): float
    {
        return TimeRecord::where('project_id', $this->record->id)->sum('revenue');
    }
}
