<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Widgets\ChartWidget;

class CoursePopularityChart extends ChartWidget
{
    protected static ?string $heading = 'Most Popular Courses';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $courses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Enrollments',
                    'data' => $courses->pluck('enrollments_count'),
                    'backgroundColor' => [
                        '#6366f1',
                        '#818cf8',
                        '#a5b4fc',
                        '#c7d2fe',
                        '#e0e7ff',
                    ],
                ],
            ],
            'labels' => $courses->pluck('title'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
