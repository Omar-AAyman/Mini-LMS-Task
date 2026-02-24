<?php

namespace App\Livewire;

use App\Models\Level;
use Livewire\Component;

class MyLearning extends Component
{
    public $perPage = 8;

    public $search = '';

    public $selectedLevel = '';

    public function updatedSearch()
    {
        $this->perPage = 8;
    }

    public function updatedSelectedLevel()
    {
        $this->perPage = 8;
    }

    public function loadMore()
    {
        $this->perPage += 8;
    }

    public function render()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->redirect(route('login'));
        }

        $query = $user->enrollments()
            ->whereHas('course', function ($q) {
                if ($this->search) {
                    $q->where(function ($sub) {
                        $sub->where('title', 'like', '%'.$this->search.'%')
                            ->orWhere('description', 'like', '%'.$this->search.'%');
                    });
                }
                if ($this->selectedLevel) {
                    $q->where('level_id', $this->selectedLevel);
                }
            })
            ->with(['course.lessons', 'course.level']);

        $totalEnrollments = (clone $query)->count();
        $hasMore = $totalEnrollments > $this->perPage;

        $enrollments = $query->latest()->take($this->perPage)->get();
        $userProgress = $user->progress()->get();

        $enrolledCourses = $enrollments->map(function ($enrollment) use ($userProgress) {
            $course = $enrollment->course;
            if (! $course) {
                return null;
            }

            $lessons = $course->lessons;
            $totalLessons = $lessons->count();

            $courseProgressRecords = $userProgress->whereIn('lesson_id', $lessons->pluck('id'));
            $completedLessonsCount = $courseProgressRecords->whereNotNull('completed_at')->count();

            $progressPercent = $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100) : 0;
            $completedLessonIds = $courseProgressRecords->whereNotNull('completed_at')->pluck('lesson_id')->toArray();

            $resumeLesson = $lessons->first(fn ($lesson) => ! in_array($lesson->id, $completedLessonIds));
            if (! $resumeLesson && $lessons->isNotEmpty()) {
                $resumeLesson = $lessons->last();
            }

            return [
                'course' => $course,
                'progress' => $progressPercent,
                'resumeLesson' => $resumeLesson,
                'enrolled_at' => $enrollment->created_at,
            ];
        })->filter();

        $levels = Level::all();

        return view('livewire.my-learning', [
            'enrolledCourses' => $enrolledCourses,
            'levels' => $levels,
            'totalEnrollments' => $totalEnrollments,
            'hasMore' => $hasMore,
        ])->layout('layouts.app');
    }
}
