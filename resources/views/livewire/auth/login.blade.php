<div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8 text-slate-900">
    <div class="w-full max-w-[460px] animate-fade-in-up">
        <!-- Brand/Logo Area -->
        <div class="mb-10 text-center">
            <div class="flex items-center justify-center gap-6 mb-6">
                <img src="{{ asset('images/jakarta_logo.png') }}" alt="DKI Jakarta" class="h-12 w-auto object-contain">
                <div class="h-10 w-px bg-slate-200"></div>
                <img src="{{ asset('images/tarakan_logo.png') }}" alt="RSUD Tarakan" class="h-14 w-auto object-contain">
                <div class="h-10 w-px bg-slate-200"></div>
                <img src="{{ asset('images/jaksehat_logo.png') }}" alt="JakSehat" class="h-12 w-auto object-contain">
            </div>

            <h1 class="text-2xl font-bold tracking-tight font-display">Sistem Autentikasi Terintegrasi</h1>
            <p class="mt-2 text-sm font-medium text-slate-500 uppercase tracking-widest">RSUD Tarakan Jakarta</p>

            @if ($appName)
                <div
                    class="mt-6 px-4 py-2 bg-teal-50/50 backdrop-blur-sm border border-teal-100 rounded-xl inline-flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                    </span>
                    <p class="text-sm font-medium text-teal-800">
                        Menghubungkan ke <span class="font-bold">{{ $appName }}</span>
                    </p>
                </div>
            @endif
        </div>

        <div
            class="glass p-8 sm:p-10 rounded-[2.5rem] shadow-premium relative overflow-hidden border border-slate-200/60">
            <!-- Subtle Decorative Health Element -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-teal-50/50 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-emerald-50/50 rounded-full blur-3xl"></div>

            <form wire:submit="authenticate" class="space-y-6 relative z-10">
                <div class="space-y-1.5">
                    <label for="username" class="block text-sm font-semibold text-slate-700 ml-1">Nama Pengguna atau
                        Email</label>
                    <div class="relative group">
                        <input wire:model="username" id="username" type="text" autofocus
                            class="block w-full px-4 py-3 bg-white/40 border-slate-200 rounded-2xl text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 outline-none"
                            placeholder="username / email@rsudtarakan.id">
                    </div>
                    @error('username')
                        <span class="block px-1 text-xs font-medium text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between px-1">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                        <a href="#"
                            class="text-xs font-bold text-teal-600 hover:text-teal-700 transition-colors uppercase tracking-wider">
                            Lupa?
                        </a>
                    </div>
                    <div class="relative group">
                        <input wire:model="password" id="password" type="password"
                            class="block w-full px-4 py-3 bg-white/40 border-slate-200 rounded-2xl text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 outline-none"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <span class="block px-1 text-xs font-medium text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center px-1">
                    <div class="flex items-center cursor-pointer group">
                        <input wire:model="remember" id="remember_me" type="checkbox"
                            class="w-5 h-5 rounded-lg border-slate-300 text-teal-600 focus:ring-teal-500/20 transition-all cursor-pointer">
                        <label for="remember_me"
                            class="ml-3 text-sm font-medium text-slate-600 group-hover:text-slate-900 transition-colors cursor-pointer">
                            Tetap masuk
                        </label>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="relative w-full py-4 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl shadow-lg hover:shadow-teal-900/10 active:scale-[0.98] transition-all duration-300 flex justify-center items-center overflow-hidden group">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-teal-500/0 via-teal-500/10 to-teal-500/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000">
                        </div>

                        <span wire:loading.remove wire:target="authenticate"
                            class="relative z-10 flex items-center gap-2 tracking-wide uppercase text-sm">
                            Masuk Ke Akun
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor"
                                class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </span>

                        <span wire:loading wire:target="authenticate" class="relative z-10 flex items-center gap-3">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Memverifikasi...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-10 flex flex-col items-center gap-4">
            <p class="text-center text-xs font-semibold text-slate-400 uppercase tracking-widest">
                &copy; {{ date('Y') }} RSUD Tarakan. Pelayanan Berkualitas & Profesional.
            </p>
        </div>
    </div>
</div>
