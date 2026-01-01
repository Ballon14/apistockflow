<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', \App\Models\Product::count())
                ->description('Total products available')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success'),
            Stat::make('Low Stock Products', \App\Models\Product::lowStock()->count())
                ->description('Products below min stock')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Pending Orders', \App\Models\SalesOrder::where('status', 'pending')->count())
                ->description('Orders waiting for processing')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Total Revenue', 'Rp ' . number_format(\App\Models\SalesOrder::where('status', 'completed')->sum('total_amount'), 0, ',', '.'))
                ->description('Total sales revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
