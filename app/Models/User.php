<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function completions()
    {
        return $this->hasMany(CourseCompletion::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
}
