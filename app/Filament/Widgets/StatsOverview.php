<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEnrollments = Enrollment::count();
        $totalCompletions = CourseCompletion::count();
        $totalUsers = \App\Models\User::where('is_admin', false)->count();
        
        $avgCompletion = $totalEnrollments > 0 
            ? round(($totalCompletions / $totalEnrollments) * 100, 1) 
            : 0;

        return [
            Stat::make('Total Students', $totalUsers)
                ->description('Active learners')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Active Courses', Course::where('is_published', true)->count())
                ->description('Published content')
                ->descriptionIcon('heroicon-m-book-open'),
            Stat::make('Enrollments', $totalEnrollments)
                ->description('Total course joins')
                ->descriptionIcon('heroicon-m-academic-cap'),
            Stat::make('Completion Rate', $avgCompletion . '%')
                ->description('Students who finished')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($avgCompletion > 50 ? 'success' : 'warning'),
        ];
    }
}
