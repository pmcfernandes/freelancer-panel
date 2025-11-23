<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;
use App\Filament\Pages\Widgets\DashboardWidgets;
use App\Filament\Pages\Widgets\RevenueExpensedChartWidget;
use App\Filament\Pages\Widgets\WorkedHoursPerMonthChartWidget;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $slug = 'dashboard';

    protected static ?int $navigationSort = 1;

    public function persistsFiltersInSession(): bool
    {
        return false;
    }

    protected function getFooterWidgets(): array
    {
        return [
            DashboardWidgets::class,
            RevenueExpensedChartWidget::class,
            WorkedHoursPerMonthChartWidget::class
        ];
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('filterByYear')
                   ->label('Filter by')
                   ->options(function () {
                        $current = (int) date('Y');
                        $years = range($current, $current - 4);
                        return array_combine($years, $years);
                    })
                    ->default(date('Y'))
                    ->reactive(),
            ]);
    }
}
