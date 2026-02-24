<?php

use App\Http\Controllers\AuthController;
use App\Livewire\CourseView;
use App\Livewire\Home;
use App\Livewire\LessonPlayer;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/courses/{course:slug}', CourseView::class)->name('courses.show');

Route::get('/courses/{course:slug}/lessons/{lesson:slug}', LessonPlayer::class)
    ->name('lessons.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/my-learning', \App\Livewire\MyLearning::class)->name('my-learning');

    Route::get('/profile', \App\Livewire\Profile::class)->name('profile')->middleware('throttle:10,1');
});
