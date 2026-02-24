<div class="min-h-screen">
    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="/"
                class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors font-medium">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-900 dark:text-white font-medium truncate max-w-xs">{{ $course->title }}</span>
        </nav>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="lg:grid lg:grid-cols-3 lg:gap-10 lg:items-start">

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-5 mb-8 lg:mb-0 lg:sticky lg:top-24">
                {{-- Course Card --}}
                <div
                    class="bg-white dark:bg-white/[0.03] rounded-3xl overflow-hidden border border-gray-200/60 dark:border-white/[0.06] shadow-sm">
                    {{-- Image --}}
                    <div
                        class="relative h-52 overflow-hidden bg-gradient-to-br from-primary-100 to-purple-100 dark:from-primary-900/20 dark:to-purple-900/20">
                        @if ($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-600/20 to-cyan-500/20 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-primary-500/60" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                        </div>
                        <div class="absolute bottom-3 left-3">
                            <span
                                class="px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm text-white text-xs font-bold uppercase tracking-wider border border-white/20">
                                {{ $course->level->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <h1 class="text-xl font-black text-gray-900 dark:text-white leading-tight">{{ $course->title }}
                        </h1>

                        {{-- Progress Bar (enrolled users) --}}
                        @if ($isEnrolled)
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs font-semibold">
                                    <span class="text-gray-500 dark:text-gray-400 uppercase tracking-wider">Your
                                        progress</span>
                                    <span
                                        class="text-primary-600 dark:text-primary-400 tabular-nums">{{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-white/5 rounded-full h-2 overflow-hidden">
                                    <div class="progress-bar h-2 rounded-full transition-all duration-1000 ease-out"
                                        x-data="{ p: 0 }" x-init="setTimeout(() => p = {{ $progress }}, 200)" :style="'width: ' + p + '%'">
                                    </div>
                                </div>
                                @if ($progress >= 100)
                                    <div
                                        class="flex items-center space-x-1.5 text-emerald-600 dark:text-emerald-400 text-xs font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Course completed! 🎉</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- CTA --}}
                        @if ($isEnrolled)
                            @php $firstLesson = $course->lessons->first(); @endphp
                            @if ($firstLesson)
                                <a href="{{ route('lessons.show', [$course->slug, $firstLesson->slug]) }}"
                                    class="flex items-center justify-center w-full px-5 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] transition-all duration-200 text-sm">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    </svg>
                                    {{ $progress > 0 ? 'Continue Learning' : 'Start Course' }}
                                </a>
                            @endif
                        @else
                            <button type="button" wire:click.prevent="enroll" wire:loading.attr="disabled"
                                class="flex items-center justify-center w-full px-5 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] transition-all duration-200 text-sm disabled:opacity-70 disabled:cursor-not-allowed disabled:scale-100">
                                <svg wire:loading wire:target="enroll"
                                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <svg wire:loading.remove wire:target="enroll" class="w-5 h-5 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span wire:loading.remove wire:target="enroll">Enroll for free</span>
                                <span wire:loading wire:target="enroll">Enrolling...</span>
                            </button>
                        @endif

                        {{-- Course Meta --}}
                        <div
                            class="pt-2 border-t border-gray-100 dark:border-white/5 grid grid-cols-2 gap-3 text-center">
                            <div>
                                <p class="text-lg font-black text-gray-900 dark:text-white">
                                    {{ $course->lessons->count() }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Lessons</p>
                            </div>
                            <div>
                                <p class="text-lg font-black text-gray-900 dark:text-white">
                                    {{ $course->formatted_duration }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Description --}}
                <div
                    class="bg-white dark:bg-white/[0.03] rounded-3xl p-8 border border-gray-200/60 dark:border-white/[0.06] shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">About this course</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-[15px]">
                        {{ $course->description ?? 'This comprehensive course will take you from zero to professional. Learn practical, real-world skills with hands-on projects.' }}
                    </p>
                </div>

                {{-- Lesson Accordion (Alpine.js) --}}
                <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200/60 dark:border-white/[0.06] shadow-sm overflow-hidden"
                    x-data="{ active: null }">

                    <div
                        class="px-8 py-6 border-b border-gray-100 dark:border-white/5 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Course Content</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $course->lessons->count() }} lessons •
                                {{ $course->lessons->where('is_free_preview', true)->count() }} free previews
                            </p>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach ($course->lessons as $index => $lesson)
                            @php
                                $canAccess = $isEnrolled || $lesson->is_free_preview;
                                $isLessonCompleted =
                                    auth()->check() &&
                                    auth()
                                        ->user()
                                        ->progress()
                                        ->where('lesson_id', $lesson->id)
                                        ->whereNotNull('completed_at')
                                        ->exists();
                            @endphp

                            <div>
                                {{-- Accordion Header --}}
                                <button
                                    @click="active = (active === {{ $index }} ? null : {{ $index }})"
                                    class="w-full flex items-center gap-4 px-8 py-4 hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors text-left">

                                    {{-- Number / Check --}}
                                    <div
                                        class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold
                                        {{ $isLessonCompleted
                                            ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400'
                                            : 'bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300' }}">
                                        @if ($isLessonCompleted)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>

                                    {{-- Title --}}
                                    <div class="flex-1 min-w-0">
                                        <span
                                            class="font-semibold text-gray-900 dark:text-white text-sm leading-snug block truncate">
                                            {{ $lesson->title }}
                                        </span>
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 flex items-center gap-1">
                                            @if ($lesson->duration_seconds)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ floor($lesson->duration_seconds / 60) }}m
                                            @endif
                                            @if ($lesson->is_free_preview)
                                                <span
                                                    class="ml-1 px-1.5 py-0.5 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded text-[10px] font-bold uppercase">Free</span>
                                            @endif
                                        </span>
                                    </div>

                                    {{-- Lock / Chevron --}}
                                    <div class="flex-shrink-0 flex items-center gap-2">
                                        @if (!$canAccess)
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        @endif
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-300 flex-shrink-0"
                                            :class="{ 'rotate-180': active === {{ $index }} }" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>

                                {{-- Accordion Body --}}
                                <div x-show="active === {{ $index }}" x-collapse x-cloak
                                    class="bg-gray-50/50 dark:bg-white/[0.015] border-t border-gray-100 dark:border-white/5 px-8 py-4">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            @if ($lesson->duration_seconds)
                                                Video lesson • {{ floor($lesson->duration_seconds / 60) }} min
                                                {{ $lesson->duration_seconds % 60 }}s
                                            @else
                                                Video lesson
                                            @endif
                                        </p>
                                        @if ($canAccess)
                                            <a href="{{ route('lessons.show', [$course->slug, $lesson->slug]) }}"
                                                class="flex items-center space-x-1.5 px-4 py-1.5 bg-primary-500 hover:bg-primary-600 text-white text-xs font-bold rounded-xl transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                </svg>
                                                <span>Watch</span>
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Enroll to unlock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
