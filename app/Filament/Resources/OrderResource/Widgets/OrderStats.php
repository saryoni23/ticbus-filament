<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Faker\Core\Number;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending', Order::query()->where('status', 'pending')->count()),
            Stat::make('Dibayar', Order::query()->where('status', 'paid')->count()),
            Stat::make('Belum Dibayar', Order::query()->where('status', 'unpaid')->count()),
            // Stat::make('Total', function () {
            //     $total = Order::query()->sum('items.harga_total');
            //     return 'Rp ' . number_format($total, 2);
            // })
        ];
    }
}
