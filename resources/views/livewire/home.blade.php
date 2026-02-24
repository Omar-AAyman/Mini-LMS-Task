<div>
    {{-- Hero Section --}}
    <div
        class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-cyan-500 to-pink-600 dark:from-slate-900 dark:via-primary-900/50 dark:to-slate-900">
        {{-- Background decoration --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-[400px] h-[400px] rounded-full bg-cyan-400/10 blur-3xl"></div>
            <svg class="absolute inset-0 w-full h-full opacity-5" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <div
                class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white/90 text-sm font-medium mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>{{ $totalCourses }}+ courses available now</span>
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-none mb-6">
                Build Your<br>
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-pink-200 to-cyan-200">Dream
                    Career</span>
            </h1>
            <p class="text-lg sm:text-xl text-white/75 max-w-2xl mx-auto mb-10 font-light leading-relaxed">
                Master in-demand skills with expert-led courses. Learn at your own pace and transform your professional
                life.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="/register"
                        class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-primary-700 bg-white rounded-2xl shadow-2xl shadow-black/20 hover:scale-105 hover:shadow-3xl transition-all duration-200">
                        Start learning free
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    <a href="/login"
                        class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white border-2 border-white/30 rounded-2xl hover:bg-white/10 transition-all duration-200">
                        Sign in
                    </a>
                @else
                    <a href="#courses"
                        class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-primary-700 bg-white rounded-2xl shadow-2xl hover:scale-105 transition-all duration-200">
                        Browse courses
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                @endguest
            </div>

            {{-- Stats Row --}}
            <div class="grid grid-cols-3 gap-6 max-w-lg mx-auto mt-16">
                @foreach ([[$totalLessons . '+', 'Lessons'], ['Expert', 'Instructors'], ['Free', 'Preview']] as [$num, $label])
                    <div class="text-center">
                        <p class="text-2xl font-black text-white">{{ $num }}</p>
                        <p class="text-xs text-white/60 font-medium uppercase tracking-wider mt-0.5">{{ $label }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Courses Grid --}}
    <div id="courses" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 dark:text-white tracking-tight">
                Explore Courses
            </h2>
            <p class="mt-3 text-lg text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                Handpicked courses designed to take you from beginner to professional.
            </p>
        </div>

        {{-- Search and Filter Bar --}}
        <div class="mb-12 flex flex-col sm:flex-row items-center gap-4 max-w-4xl mx-auto">
            <div class="relative w-full sm:w-2/3">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Search courses by title or description..."
                    class="block w-full pl-11 pr-4 py-4 bg-white/70 dark:bg-[#151c2c]/70 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 shadow-sm transition-all font-medium">
            </div>

            <div class="relative w-full sm:w-1/3">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <select wire:model.live="selectedLevel"
                    class="block w-full pl-11 pr-10 py-4 bg-white/70 dark:bg-[#151c2c]/70 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-2xl text-gray-900 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-500 shadow-sm transition-all appearance-none cursor-pointer font-medium">
                    <option value="">All Levels</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        @if ($courses->isEmpty())
            <div class="text-center py-20">
                <div
                    class="w-20 h-20 rounded-3xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 font-medium">No published courses yet. Check back soon!</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <a href="{{ route('courses.show', $course->slug) }}"
                        class="course-card group flex flex-col bg-white dark:bg-white/[0.03] rounded-3xl overflow-hidden border border-gray-200/60 dark:border-white/[0.06] shadow-sm hover:border-primary-300/50 dark:hover:border-primary-500/30">

                        {{-- Thumbnail --}}
                        <div
                            class="relative h-52 overflow-hidden bg-gradient-to-br from-primary-100 to-purple-100 dark:from-primary-900/20 dark:to-purple-900/20">
                            @if ($course->image)
                                <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div
                                        class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-600/20 to-cyan-500/20 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-primary-500/60" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                            {{-- Level badge overlay --}}
                            <div class="absolute top-3 left-3">
                                @php
                                    $levelColors = [
                                        'Beginner' => 'emerald',
                                        'Intermediate' => 'amber',
                                        'Advanced' => 'red',
                                    ];
                                    $c = $levelColors[$course->level->name] ?? 'primary';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/90 dark:bg-black/50 backdrop-blur-sm text-gray-800 dark:text-white shadow-sm border border-white/50">
                                    {{ $course->level->name }}
                                </span>
                            </div>
                            {{-- Lesson count --}}
                            <div class="absolute top-3 right-3">
                                <span
                                    class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-black/40 backdrop-blur-sm text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.069A1 1 0 0121 8.868v6.264a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $course->lessons_count ?? $course->lessons->count() }} lessons</span>
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col flex-1 p-6 space-y-3">
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white leading-snug group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2">
                                {{ $course->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 flex-1 leading-relaxed">
                                {{ $course->description ?? 'Start your learning journey with this comprehensive course.' }}
                            </p>
                            <div class="flex items-center justify-between pt-2">
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="flex items-center text-xs font-semibold text-gray-500 dark:text-gray-400">
                                        <svg class="w-3.5 h-3.5 mr-1 text-primary-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $course->formatted_duration }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-700"></span>
                                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                        {{ $course->lessons->count() }} lessons
                                    </span>
                                </div>
                                <span
                                    class="flex items-center text-sm font-semibold text-primary-600 dark:text-primary-400 group-hover:translate-x-1 transition-transform duration-200">
                                    View course
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

    </div>

    @if ($hasMore)
        <div x-data x-intersect.full="$wire.loadMore()" class="mt-12 flex justify-center w-full py-8">
            <div class="flex items-center space-x-2 text-cyan-600 dark:text-cyan-400">
                <svg class="animate-spin w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="font-medium text-sm">Loading more courses...</span>
            </div>
        </div>
    @endif
    @endif
</div>
