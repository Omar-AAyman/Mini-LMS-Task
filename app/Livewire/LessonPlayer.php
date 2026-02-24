<?php

namespace App\Livewire;

use App\Actions\CompleteLessonAction;
use App\Models\Course;
use App\Models\Lesson;
use Livewire\Component;

class LessonPlayer extends Component
{
    public Course $course;

    public Lesson $lesson;

    public function mount(Course $course, Lesson $lesson)
    {
        $this->course = $course;
        $this->lesson = $lesson;

        if (! $this->lesson->is_free_preview && ! auth()->check()) {
            return $this->redirect(route('login'));
        }

        if (auth()->check()) {
            $isEnrolled = auth()->user()->enrollments()->where('course_id', $this->course->id)->exists();
            if (! $isEnrolled && ! $this->lesson->is_free_preview) {
                return $this->redirect(route('courses.show', $this->course->slug));
            }
        }
    }

    public function completeLesson()
    {
        if (! auth()->check()) {
            return;
        }

        try {
            app(CompleteLessonAction::class)(auth()->user(), $this->lesson);
            $this->dispatch('notify', message: 'Lesson marked as completed!', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function saveProgress(int $seconds)
    {
        if (! auth()->check()) {
            return;
        }

        $progress = auth()->user()->progress()->firstOrNew([
            'lesson_id' => $this->lesson->id,
        ]);

        if (! $progress->exists && ! $progress->started_at) {
            $progress->started_at = now();
        }

        $progress->watch_seconds = $seconds;
        $progress->save();
    }

    public function render()
    {
        $nextLesson = $this->course->lessons()
            ->where('order', '>', $this->lesson->order)
            ->first();

        $previousLesson = $this->course->lessons()
            ->where('order', '<', $this->lesson->order)
            ->orderBy('order', 'desc')
            ->first();

        $progressRecord = auth()->check() ? auth()->user()->progress()
            ->where('lesson_id', $this->lesson->id)
            ->first() : null;

        $isCompleted = $progressRecord && $progressRecord->completed_at !== null;
        $watchSeconds = $progressRecord ? $progressRecord->watch_seconds : 0;

        $isEnrolled = auth()->check() && auth()->user()->enrollments()
            ->where('course_id', $this->course->id)
            ->exists();

        return view('livewire.lesson-player', [
            'nextLesson'     => $nextLesson,
            'previousLesson' => $previousLesson,
            'isCompleted'    => $isCompleted,
            'isEnrolled'     => $isEnrolled,
            'watchSeconds'   => $watchSeconds,
        ])->layout('layouts.app');
    }
}
