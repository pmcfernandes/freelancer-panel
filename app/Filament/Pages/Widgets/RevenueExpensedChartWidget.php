<?php

namespace App\Filament\Pages\Widgets;

use App\Models\Expense;
use App\Models\Invoice;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class RevenueExpensedChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Revenue vs Expenses';

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

        $revenue_data = Invoice::whereIn('status', ['paid'])
            ->whereYear('invoice_date', $filterByYear)
            ->selectRaw('MONTH(invoice_date) as month, SUM(total_amount) as total_amount')
            ->groupBy('month')
            ->pluck('total_amount', 'month')
            ->toArray();

        $expense_data = Expense::where('status', 'approved')
            ->whereYear('expense_date', $filterByYear)
            ->selectRaw('MONTH(expense_date) as month, SUM(amount) as total_amount')
            ->groupBy('month')
            ->pluck('total_amount', 'month')
            ->toArray();

        $revenues = [
            'label' => 'Revenue',
            'data' => array_map(function ($m) use ($revenue_data) {
                return isset($revenue_data[$m]) ? (float) $revenue_data[$m] : 0.0;
            }, $months),
            'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'borderWidth' => 1,
        ];

        $expenses = [
            'label' => 'Expenses',
            'data' => array_map(function ($m) use ($expense_data) {
                return isset($expense_data[$m]) ? (float) $expense_data[$m] : 0.0;
            }, $months),
            'backgroundColor' => 'rgba(255, 99, 132, 0.6)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
            'borderWidth' => 1,
        ];

        return [$revenues, $expenses];
    }
}
