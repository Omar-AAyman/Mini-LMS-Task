<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Career 180 — Learn Without Limits' }}</title>
    <meta name="description" content="Career 180 — A modern learning platform to advance your career.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>

    <!-- Plyr CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />



    <!-- Custom Global Components for Tailwind CDN -->
    <style type="text/tailwindcss">
        @layer components {
            .card-glass {
                @apply bg-white/70 dark:bg-[#151c2c]/70 backdrop-blur-xl border border-gray-200 dark:border-white/5 shadow-xl shadow-gray-200/50 dark:shadow-none;
            }

            .btn-primary {
                @apply inline-flex items-center justify-center rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold shadow-lg shadow-blue-500/25 transition-all duration-200 hover:shadow-blue-500/40 hover:-translate-y-0.5;
            }
        }
    </style>

    @livewireStyles

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenu: false }" x-init="$watch('darkMode', v => document.documentElement.classList.toggle('dark', v));
document.documentElement.classList.toggle('dark', darkMode)"
    class="bg-gray-50 dark:bg-[#0f172a] text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-300 min-h-screen">

    <!-- Navigation -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-[#0f172a]/80 border-b border-gray-200/50 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2 group">
                    <div
                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-xl font-black tracking-tight">
                        <span class="gradient-text">Career</span><span class="text-gray-900 dark:text-white"> 180</span>
                    </span>
                </a>

                <div class="flex max-md:hidden items-center space-x-4">
                    <!-- 1. Home Link -->
                    <a href="/"
                        class="flex items-center space-x-1 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-50 dark:hover:bg-white/5 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Home</span>
                    </a>

                    @auth
                        <!-- 2. My Learning Link -->
                        <a href="/my-learning"
                            class="flex items-center space-x-1 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-50 dark:hover:bg-white/5 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>My Learning</span>
                        </a>

                        <!-- 3. Admin Link -->
                        @if (auth()->user()->is_admin)
                            <a href="/admin"
                                class="flex items-center space-x-1 px-3 py-1.5 text-sm font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-500/10 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Admin</span>
                            </a>
                        @endif

                        <!-- 4. User Profile & Badge -->
                        <div class="flex items-center space-x-1 pl-2 border-l border-gray-200 dark:border-white/10">
                            <a href="{{ route('profile') }}"
                                class="flex items-center space-x-2 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 rounded-xl transition-colors">
                                <div
                                    class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white text-[10px] font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span>Profile</span>
                            </a>

                            <button type="button" onclick="document.getElementById('logout-form').submit()"
                                class="px-3 py-1.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors">
                                Sign out
                            </button>
                        </div>
                    @else
                        <!-- Guest Links -->
                        <div class="flex items-center space-x-2">
                            <a href="/login"
                                class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                Sign in
                            </a>
                            <a href="/register"
                                class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-500 rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-105 transition-all duration-200">
                                Get started
                            </a>
                        </div>
                    @endauth

                    <!-- 5. Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="relative p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition-all duration-200 hover:scale-110"
                        :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 18v1m9-9h1M3 9h1m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile hamburger -->
                <button @click="mobileMenu = !mobileMenu"
                    class="md:hidden p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" x-cloak />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="md:hidden pb-4 border-t border-gray-200/50 dark:border-white/5 pt-4 space-y-2">
                @auth
                    <div class="flex items-center space-x-2 px-3 py-2">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </div>

                    <a href="{{ route('profile') }}"
                        class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-white/10">Profile</a>

                    <a href="/my-learning"
                        class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-white/10">My
                        Learning</a>

                    @if (auth()->user()->is_admin)
                        <a href="/admin"
                            class="block px-3 py-2 text-sm text-primary-600 dark:text-primary-400 font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-white/10">Admin
                            Panel</a>
                    @endif
                    <button type="button" onclick="document.getElementById('logout-form').submit()"
                        class="w-full text-left px-3 py-2 text-sm text-red-600 font-medium rounded-xl hover:bg-red-50 dark:hover:bg-red-500/10">Sign
                        out</button>
                @else
                    <a href="/login"
                        class="block px-3 py-2 text-sm font-semibold hover:bg-gray-100 dark:hover:bg-white/10 rounded-xl">Sign
                        in</a>
                    <a href="/register"
                        class="block px-3 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-500 rounded-xl text-center">Get
                        started</a>
                @endauth
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                    class="w-full text-left px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-white/10 rounded-xl flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <span x-text="darkMode ? 'Light mode' : 'Dark mode'"></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Global Notification System -->
    <div x-data="{
        show: {{ session()->has('success') || session()->has('error') || $errors->any() ? 'true' : 'false' }},
        message: '{{ session('success') ?? (session('error') ?? ($errors->any() ? 'Please fix the errors below.' : '')) }}',
        type: '{{ session()->has('error') || $errors->any() ? 'error' : 'success' }}'
    }"
        @notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 4000);"
        x-init="if (show) setTimeout(() => show = false, 4000);" x-show="show" style="display: none;"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
        :class="type === 'error' ? 'bg-red-500 shadow-red-500/30' : 'bg-emerald-500 shadow-emerald-500/30'"
        class="fixed top-20 right-4 z-50 flex items-center space-x-3 px-5 py-3.5 text-white rounded-2xl shadow-2xl text-sm font-medium">

        <template x-if="type === 'success'">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </template>

        <template x-if="type === 'error'">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </template>

        <span x-text="message"></span>
    </div>

    <!-- Main Content -->
    <main class="pt-16">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-24 border-t border-gray-200/50 dark:border-white/5 bg-white/50 dark:bg-white/[0.02]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <a href="/" class="flex items-center space-x-2">
                    <div
                        class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="font-black text-lg"><span class="gradient-text">Career</span><span
                            class="dark:text-white"> 180</span></span>
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-500">
                    &copy; {{ date('Y') }} Career 180. Built with Laravel &amp; Livewire.
                </p>
            </div>
        </div>
    </footer>

    <!-- Hidden Logout Form (submitted via JS to bypass Livewire form interception) -->
    @auth
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none">
            @csrf
        </form>
    @endauth

    <!-- Plyr JS -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @livewireScripts
</body>

</html>
