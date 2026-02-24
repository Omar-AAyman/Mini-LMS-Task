<?php

namespace App\Livewire;

use App\Actions\EnrollUserAction;
use App\Models\Course;
use Livewire\Component;

class CourseView extends Component
{
    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course->load(['level', 'lessons']);
    }

    public function enroll()
    {
        if (!auth()->check()) {
            return $this->redirect(route('login'));
        }

        try {
            app(EnrollUserAction::class)(auth()->user(), $this->course);
            $this->dispatch('notify', message: 'Enrolled successfully! Start learning now.', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        $isEnrolled = auth()->check() && auth()->user()->enrollments()->where('course_id', $this->course->id)->exists();
        
        $progress = 0;
        if ($isEnrolled) {
            $totalLessons = $this->course->lessons->count();
            $completedLessons = auth()->user()->progress()
                ->whereIn('lesson_id', $this->course->lessons->pluck('id'))
                ->whereNotNull('completed_at')
                ->count();
            
            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        }

        return view('livewire.course-view', [
            'isEnrolled' => $isEnrolled,
            'progress' => $progress,
        ])->layout('layouts.app');
    }
}
