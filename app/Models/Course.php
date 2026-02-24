<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function getTotalDurationAttribute(): int
    {
        return $this->lessons->sum('duration_seconds');
    }

    public function getFormattedDurationAttribute(): string
    {
        $seconds = $this->total_duration;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function completions()
    {
        return $this->hasMany(CourseCompletion::class);
    }
}
