<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Career 180</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind-config.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-[#0f172a] min-h-screen flex font-sans antialiased">

    <div
        class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-blue-600 via-cyan-500 to-pink-600">
        <div class="absolute inset-0 opacity-10"><svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <defs>  
                    <pattern id="g" width="60" height="60" patternUnits="userSpaceOnUse">
                        <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#g)" />
            </svg></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-purple-400/10 blur-3xl"></div>
        <div class="relative z-10 flex flex-col justify-between p-12 w-full">
            <a href="/" class="flex items-center space-x-2">
                <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-white font-black text-xl">Career 180</span>
            </a>
            <div class="space-y-5">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-white leading-tight">Welcome<br>back.</h2>
                <p class="text-white/70 text-lg">Continue your learning journey right where you left off.</p>
            </div>
            <p class="text-white/40 text-sm">© {{ date('Y') }} Career 180</p>
        </div>
    </div>

    <div class="flex flex-1 flex-col items-center justify-center px-6 py-12 lg:px-16 bg-white dark:bg-[#0f172a]">
        <div class="w-full max-w-md">
            <a href="/" class="flex items-center space-x-2 mb-10 lg:hidden">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-xl font-black"><span class="gradient-text">Career</span> <span
                        class="text-gray-900 dark:text-white">180</span></span>
            </a>

            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900 dark:text-white">Sign in</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm">New here? <a href="/register"
                        class="font-semibold text-blue-600 dark:text-indigo-400 hover:underline">Create a free
                        account</a></p>
            </div>

            @if ($errors->any())
                <div
                    class="mb-5 flex items-start gap-3 px-4 py-3.5 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-red-700 dark:text-red-400 font-medium">{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <div>
                    <label for="email"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email
                        address</label>
                    <input id="email" name="email" type="email" required autocomplete="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-white/5 border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-200 dark:border-white/10' }} rounded-xl text-gray-900 dark:text-white placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-colors"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-colors"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 accent-blue-600">
                        <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Remember me</span>
                    </label>
                </div>

                <button type="submit" :disabled="loading" :class="{ 'opacity-70 cursor-not-allowed': loading }"
                    class="w-full flex items-center justify-center py-3.5 px-6 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] transition-all duration-200 text-sm">
                    <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span x-text="loading ? 'Signing in...' : 'Sign in'">Sign in</span>
                    <svg x-show="!loading" class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</body>

</html>
