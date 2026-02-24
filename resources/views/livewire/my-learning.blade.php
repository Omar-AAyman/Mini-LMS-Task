<div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] pt-32 pb-20">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 text-center flex flex-col items-center gap-6">
            <div class="space-y-3">
                <h1
                    class="text-4xl lg:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 tracking-tight">
                    My Learning
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Track your progress, resume your courses, and achieve your goals. Keep up the great work!
                </p>
            </div>
            @if ($enrolledCourses->isNotEmpty())
                <div class="hidden lg:flex items-center justify-center gap-4">
                    <div
                        class="px-5 py-3 rounded-2xl bg-white dark:bg-black/20 border border-gray-200 dark:border-white/5 flex items-center gap-3">
                        <div class="p-2 bg-blue-50 dark:bg-blue-500/10 rounded-xl text-blue-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Enrolled Courses</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $enrolledCourses->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
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
                    placeholder="Search your enrolled courses..."
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

        @if ($enrolledCourses->isEmpty())
            {{-- Empty State --}}
            <div class="card-glass shadow-sm rounded-3xl p-12 lg:p-24 text-center max-w-3xl mx-auto">
                <div
                    class="w-24 h-24 mx-auto mb-8 bg-blue-50 dark:bg-blue-500/10 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No courses enrolled yet</h3>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 max-w-lg mx-auto leading-relaxed">
                    You haven't enrolled in any courses yet. Browse our library to find the perfect course to kickstart
                    your journey.
                </p>
                <a href="/" class="btn-primary hover:scale-105 px-8 py-4">
                    Explore Courses
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        @else
            {{-- Course Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
                @foreach ($enrolledCourses as $data)
                    @php
                        $course = $data['course'];
                        $progress = $data['progress'];
                        $resumeLesson = $data['resumeLesson'];
                        $link = $resumeLesson
                            ? route('lessons.show', [$course->slug, $resumeLesson->slug])
                            : route('courses.show', $course->slug);
                    @endphp

                    <div
                        class="card-glass group relative flex flex-col rounded-3xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-500/10">
                        {{-- Image Area --}}
                        <div class="relative aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800">
                            @if ($course->image)
                                <img src="{{ Str::startsWith($course->image, ['http://', 'https://']) ? $course->image : Storage::url($course->image) }}"
                                    alt="{{ $course->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-600">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            @if ($progress == 100)
                                <div class="absolute top-4 right-4">
                                    <div
                                        class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center gap-1.5 backdrop-blur-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Completed
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Content Area --}}
                        <div class="p-6 flex flex-col flex-1">
                            <h3
                                class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 leading-snug group-hover:text-blue-600 dark:group-hover:text-indigo-400 transition-colors">
                                <a href="{{ route('courses.show', $course->slug) }}">
                                    <span class="absolute inset-0 z-10"></span>
                                    {{ $course->title }}
                                </a>
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">
                                {{ $course->description }}
                            </p>

                            <div class="flex items-center gap-4 mb-6 text-xs font-semibold text-gray-400">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $course->formatted_duration }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    {{ $course->lessons->count() }} lessons
                                </span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100 dark:border-white/5">
                                {{-- Progress indicator --}}
                                <div class="mb-5 relative z-20">
                                    <div class="flex items-center justify-between text-sm mb-2">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Course
                                            Progress</span>
                                        <span
                                            class="font-bold {{ $progress == 100 ? 'text-emerald-500' : 'text-blue-600 dark:text-indigo-400' }}">{{ $progress }}%</span>
                                    </div>
                                    <div class="h-2 w-full bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full {{ $progress == 100 ? 'bg-emerald-500' : 'bg-gradient-to-r from-blue-600 to-cyan-500' }} rounded-full transition-all duration-1000 ease-out"
                                            style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ $link }}"
                                    class="relative z-20 w-full {{ $progress == 100 ? 'flex items-center justify-center py-3.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-900 dark:bg-[#0f172a] dark:border dark:border-white/10 dark:hover:bg-white/5 dark:text-white font-semibold rounded-xl transition-all duration-200' : 'btn-primary py-3.5 px-4' }}">
                                    {{ $progress == 100 ? 'Watch Again' : ($progress > 0 ? 'Resume Learning' : 'Start Course') }}
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
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
                <span class="font-medium text-sm">Loading more enrolled courses...</span>
            </div>
        </div>
    @endif
    @endif
</div>
</div>
