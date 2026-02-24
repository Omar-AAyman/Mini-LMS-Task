<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Level;
use App\Models\Lesson;
use Livewire\Component;

class Home extends Component
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
        $query = Course::with('level')
            ->where('is_published', true)
            ->when($this->search, function ($q) {
                $q->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->selectedLevel, function ($q) {
                $q->where('level_id', $this->selectedLevel);
            });

        $totalLessons = Lesson::whereHas('course', function ($q) {
            $q->where('is_published', true);
        })->count();

        $filteredTotal = (clone $query)->count();
        $hasMore = $filteredTotal > $this->perPage;
        
        $totalCourses = Course::where('is_published', true)->count();

        $courses = $query->latest()->take($this->perPage)->get();
        $levels = Level::all();

        return view('livewire.home', [
            'courses' => $courses,
            'levels' => $levels,
            'totalCourses' => $totalCourses,
            'filteredTotal' => $filteredTotal,
            'hasMore' => $hasMore,
            'totalLessons' => $totalLessons,
        ])->layout('layouts.app');
    }
}
