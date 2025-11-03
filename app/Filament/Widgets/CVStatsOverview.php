<?php

namespace App\Filament\Widgets;

use App\Models\CV;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CVStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalCVs = CV::where('user_id', auth()->id())->count();
        $activeCVs = CV::where('user_id', auth()->id())->where('is_active', true)->count();
        $activePercentage = $totalCVs > 0 ? round(($activeCVs / $totalCVs) * 100) : 0;

        $cvsThisMonth = CV::where('user_id', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $cvsLastMonth = CV::where('user_id', auth()->id())
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $monthlyChange = $cvsLastMonth > 0
            ? round((($cvsThisMonth - $cvsLastMonth) / $cvsLastMonth) * 100)
            : 0;

        $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
            return CV::where('user_id', auth()->id())->whereDate('created_at', now()->subDays($daysAgo))->count();
        })->toArray();

        return [
            Stat::make('Total CVs', $totalCVs)
                ->description('All time')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Active CVs', $activeCVs)
                ->description("{$activePercentage}% of total")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('CVs This Month', $cvsThisMonth)
                ->description($monthlyChange >= 0 ? "{$monthlyChange}% increase" : "{$monthlyChange}% decrease")
                ->descriptionIcon($monthlyChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($last7Days)
                ->color($monthlyChange >= 0 ? 'success' : 'danger'),
        ];
    }
}
