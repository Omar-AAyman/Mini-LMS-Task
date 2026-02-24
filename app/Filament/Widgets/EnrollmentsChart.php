<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\ChartWidget;

class EnrollmentsChart extends ChartWidget
{
    protected static ?string $heading = 'Enrollment Trends';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Enrollment::selectRaw('DATE(enrolled_at) as date, COUNT(*) as count')
            ->where('enrolled_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'New Enrollments',
                    'data' => $data->map(fn ($value) => $value->count),
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn ($value) => \Carbon\Carbon::parse($value->date)->format('M d')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
