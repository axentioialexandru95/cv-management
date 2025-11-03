<?php

namespace App\Filament\Widgets;

use App\Models\CV;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CVActivityChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'year';

    public function getHeading(): ?string
    {
        return 'CV Activity';
    }

    public function getDescription(): ?string
    {
        return 'CVs created over time';
    }

    protected function getData(): array
    {
        $data = match ($this->filter) {
            'today' => $this->getTodayData(),
            'week' => $this->getWeekData(),
            'month' => $this->getMonthData(),
            'year' => $this->getYearData(),
            default => $this->getYearData(),
        };

        return [
            'datasets' => [
                [
                    'label' => 'CVs Created',
                    'data' => $data['values'],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last 7 days',
            'month' => 'Last 30 days',
            'year' => 'This year',
        ];
    }

    protected function getTodayData(): array
    {
        $labels = [];
        $values = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $labels[] = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
            $values[] = CV::whereDate('created_at', today())
                ->whereHour('created_at', $hour)
                ->count();
        }

        return ['labels' => $labels, 'values' => $values];
    }

    protected function getWeekData(): array
    {
        $labels = [];
        $values = [];

        for ($day = 6; $day >= 0; $day--) {
            $date = now()->subDays($day);
            $labels[] = $date->format('D');
            $values[] = CV::whereDate('created_at', $date)->count();
        }

        return ['labels' => $labels, 'values' => $values];
    }

    protected function getMonthData(): array
    {
        $labels = [];
        $values = [];

        for ($day = 29; $day >= 0; $day--) {
            $date = now()->subDays($day);
            $labels[] = $date->format('M j');
            $values[] = CV::whereDate('created_at', $date)->count();
        }

        return ['labels' => $labels, 'values' => $values];
    }

    protected function getYearData(): array
    {
        $labels = [];
        $values = [];

        for ($month = 11; $month >= 0; $month--) {
            $date = now()->subMonths($month)->startOfMonth();
            $labels[] = $date->format('M Y');
            $values[] = CV::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
