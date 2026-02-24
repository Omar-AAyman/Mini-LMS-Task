<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header Section --}}
        <div
            class="relative overflow-hidden p-8 rounded-3xl bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-white/10 shadow-xl shadow-blue-500/5">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">My Profile</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Manage your account settings and security</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Account Information Form --}}
            <section
                class="bg-white/80 dark:bg-[#1e293b]/50 backdrop-blur-xl border border-gray-100 dark:border-white/10 rounded-3xl p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Account Info</h2>
                </div>

                <form wire:submit="updateProfile" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">Full
                            Name</label>
                        <input wire:model="form.name" type="text"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-[#0f172a]/40 border border-gray-200 dark:border-white/5 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all">
                        @error('form.name')
                            <span class="text-xs text-red-500 mt-1 block ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">Email
                            Address</label>
                        <input wire:model="form.email" type="email"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-[#0f172a]/40 border border-gray-200 dark:border-white/5 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all">
                        @error('form.email')
                            <span class="text-xs text-red-500 mt-1 block ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full flex items-center justify-center py-3.5 bg-gray-900 dark:bg-white dark:text-gray-900 text-white font-bold rounded-2xl hover:scale-[1.02] active:scale-95 transition-all text-sm shadow-lg shadow-gray-900/10 disabled:opacity-70">
                        <svg wire:loading wire:target="updateProfile" class="animate-spin -ml-1 mr-3 h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                        <span wire:loading wire:target="updateProfile">Saving Account...</span>
                    </button>
                </form>
            </section>

            {{-- Password Update Form --}}
            <section
                class="bg-white/80 dark:bg-[#1e293b]/50 backdrop-blur-xl border border-gray-100 dark:border-white/10 rounded-3xl p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Security</h2>
                </div>

                <form wire:submit="updatePassword" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">New
                            Password</label>
                        <input wire:model="form.password" type="password"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-[#0f172a]/40 border border-gray-200 dark:border-white/5 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all">
                        @error('form.password')
                            <span class="text-xs text-red-500 mt-1 block ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5 ml-1">Confirm
                            Password</label>
                        <input wire:model="form.password_confirmation" type="password"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-[#0f172a]/40 border border-gray-200 dark:border-white/5 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition-all">
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full flex items-center justify-center py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-2xl hover:scale-[1.02] active:scale-95 transition-all text-sm shadow-lg shadow-purple-500/20 disabled:opacity-70">
                        <svg wire:loading wire:target="updatePassword"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove wire:target="updatePassword">Update Security</span>
                        <span wire:loading wire:target="updatePassword">Securing Account...</span>
                    </button>
                </form>
            </section>
        </div>

        <div class="p-6 rounded-3xl bg-emerald-500/5 border border-emerald-500/10 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center animate-pulse">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Account Status: Active</h3>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400">All services operational</p>
                </div>
            </div>
            <div class="hidden sm:block text-right">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-black">Membership ID</p>
                <p class="text-sm font-mono text-gray-600 dark:text-gray-300">
                    #{{ str_pad(auth()->id(), 8, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>
</div>
