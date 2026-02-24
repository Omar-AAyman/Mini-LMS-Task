<div class="min-h-screen bg-gray-950 dark:bg-[#080b14]" x-data="lessonPlayer({{ $watchSeconds ?? 0 }})">

    {{-- Top Bar (course breadcrumb + nav) --}}
    <div class="bg-gray-900/80 dark:bg-black/50 border-b border-white/5 backdrop-blur-sm">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 py-3 flex items-center gap-3">
            <a href="{{ route('courses.show', $course->slug) }}"
                class="flex items-center gap-1.5 text-sm text-gray-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to course
            </a>
            <span class="text-gray-600">·</span>
            <span class="text-sm text-gray-300 font-medium truncate">{{ $course->title }}</span>
        </div>
    </div>

    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 py-6 lg:grid lg:grid-cols-[1fr_360px] lg:gap-6">

        {{-- LEFT — Video + Info --}}
        <div class="space-y-4">
            {{-- Video Player --}}
            <div wire:ignore
                class="relative rounded-2xl overflow-hidden bg-black shadow-2xl shadow-black/50 ring-1 ring-white/5">
                @if ($lesson->video_url)
                    @php
                        // Extract YouTube video ID from URL
                        preg_match(
                            '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                            $lesson->video_url,
                            $matches,
                        );
                        $videoId = $matches[1] ?? $lesson->video_url;
                    @endphp
                    <div x-ref="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $videoId }}"></div>
                @else
                    <div class="aspect-video flex items-center justify-center text-gray-500">
                        <p class="text-sm">No video available for this lesson.</p>
                    </div>
                @endif
            </div>

            {{-- Lesson Info + Actions --}}
            <div class="bg-gray-900/50 dark:bg-white/[0.02] rounded-2xl ring-1 ring-white/5 p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl font-black text-white leading-snug">{{ $lesson->title }}</h1>
                        <div class="flex flex-wrap items-center gap-3 mt-2">
                            <span class="text-sm text-gray-400">{{ $course->title }}</span>
                            @if ($lesson->duration_seconds)
                                <span class="flex items-center gap-1 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ floor($lesson->duration_seconds / 60) }}m {{ $lesson->duration_seconds % 60 }}s
                                </span>
                            @endif
                            @if ($lesson->is_free_preview)
                                <span
                                    class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-full uppercase tracking-wider">Free
                                    Preview</span>
                            @endif
                        </div>
                    </div>

                    {{-- Completion Status --}}
                    @auth
                        @if ($isCompleted)
                            <div
                                class="flex items-center gap-2 px-4 py-2.5 bg-emerald-500/15 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm font-bold flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Completed
                            </div>
                        @else
                            <button @click="showModal = true"
                                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-105 transition-all duration-200 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Mark complete
                            </button>
                        @endif
                    @endauth
                </div>

                {{-- Prev / Next Navigation --}}
                <div class="flex items-center justify-between gap-3 mt-5 pt-5 border-t border-white/5">
                    @if ($previousLesson)
                        <a href="{{ route('lessons.show', [$course->slug, $previousLesson->slug]) }}"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl text-sm text-gray-300 font-medium transition-all hover:-translate-x-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="hidden sm:inline">Previous</span>
                        </a>
                    @else
                        <div></div>
                    @endif

                    <span class="text-xs text-gray-500 tabular-nums">
                        Lesson {{ $course->lessons->search(fn($l) => $l->id === $lesson->id) + 1 }} of
                        {{ $course->lessons->count() }}
                    </span>

                    @if ($nextLesson)
                        <a href="{{ route('lessons.show', [$course->slug, $nextLesson->slug]) }}"
                            class="flex items-center gap-2 px-4 py-2.5 bg-primary-500/10 hover:bg-primary-500/20 border border-primary-500/20 rounded-xl text-sm text-primary-400 font-medium transition-all hover:translate-x-0.5">
                            <span class="hidden sm:inline">Next lesson</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <div></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT — Lesson List Sidebar --}}
        <div class="mt-8 lg:mt-0">
            <div
                class="bg-white dark:bg-[#151c2c] rounded-2xl ring-1 ring-gray-200 dark:ring-white/5 shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden h-full">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-white/5">
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Course Content</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-0.5">{{ $course->lessons->count() }}
                        lessons</p>
                </div>
                <div
                    class="overflow-y-auto max-h-[calc(100vh-14rem)] divide-y divide-gray-100 dark:divide-white/[0.04]">
                    @foreach ($course->lessons as $idx => $l)
                        @php
                            $lCompleted =
                                auth()->check() &&
                                auth()
                                    ->user()
                                    ->progress()
                                    ->where('lesson_id', $l->id)
                                    ->whereNotNull('completed_at')
                                    ->exists();
                            $isCurrent = $l->id === $lesson->id;
                        @endphp
                        @if ($isEnrolled || $l->is_free_preview)
                            <a href="{{ route('lessons.show', [$course->slug, $l->slug]) }}"
                                class="flex items-center gap-3 px-5 py-3.5 transition-colors
                                    {{ $isCurrent ? 'bg-primary-500/15 border-l-2 border-primary-500' : 'hover:bg-white/[0.03]' }}">
                            @else
                                <div class="flex items-center gap-3 px-5 py-3.5 opacity-40 cursor-not-allowed">
                        @endif
                        {{-- Number / Check --}}
                        <div
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0
                                    {{ $lCompleted ? 'bg-emerald-500/20 text-emerald-400' : ($isCurrent ? 'bg-primary-500 text-white' : 'bg-white/5 text-gray-500') }}">
                            @if ($lCompleted)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p
                                class="text-xs font-semibold leading-snug truncate {{ $isCurrent ? 'text-white' : 'text-gray-300' }}">
                                {{ $l->title }}
                            </p>
                            @if ($l->duration_seconds)
                                <p class="text-[10px] text-gray-600 mt-0.5">{{ floor($l->duration_seconds / 60) }}m</p>
                            @endif
                        </div>

                        @if ($l->is_free_preview && !$isEnrolled)
                            <span
                                class="text-[9px] font-bold uppercase text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded flex-shrink-0">Free</span>
                        @elseif(!($isEnrolled || $l->is_free_preview))
                            <svg class="w-3.5 h-3.5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        @endif
                        @if ($isEnrolled || $l->is_free_preview)
                            </a>
                        @else
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Confirmation Modal --}}
<div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
    x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100">
    {{-- Backdrop --}}
    <div @click="showModal = false" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    {{-- Modal --}}
    <div class="relative bg-gray-900 border border-white/10 rounded-3xl shadow-2xl p-8 max-w-sm w-full z-10"
        x-show="showModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">

        <div class="text-center">
            <div class="w-16 h-16 rounded-2xl bg-primary-500/20 flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-white mb-2">Mark as Completed?</h3>
            <p class="text-sm text-gray-400 leading-relaxed mb-7">
                This will mark "{{ $lesson->title }}" as complete and update your course progress.
            </p>

            <div class="flex gap-3">
                <button @click="showModal = false"
                    class="flex-1 px-4 py-3 rounded-xl border border-white/10 text-gray-300 text-sm font-semibold hover:bg-white/5 transition-colors">
                    Cancel
                </button>
                <button
                    @click="isCompleting = true; $wire.completeLesson().then(() => { showModal = false; isCompleting = false; })"
                    :disabled="isCompleting"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-bold hover:opacity-90 transition-opacity disabled:opacity-70">
                    <svg x-show="isCompleting" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                        </path>
                    </svg>
                    <span x-text="isCompleting ? 'Saving...' : '✓ Complete'"></span>
                </button>
            </div>
        </div>
    </div>
</div>