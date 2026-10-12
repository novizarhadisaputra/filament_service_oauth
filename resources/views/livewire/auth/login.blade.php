<div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8 text-slate-900">
    <div class="w-full max-w-[460px] animate-fade-in-up">
        <!-- Brand/Logo Area -->
        <div class="mb-10 text-center">
            <div class="flex items-center justify-center gap-6 mb-6">
                <img src="{{ asset('images/jakarta_logo.png') }}" alt="DKI Jakarta"
                    class="h-10 w-auto object-contain dark:brightness-110">
                <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                <img src="{{ asset('images/jaksehat_logo.png') }}" alt="JakSehat"
                    class="h-10 w-auto object-contain dark:brightness-110">
                <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                <img src="{{ asset('images/tarakan_logo.png') }}" alt="Tarakan"
                    class="h-12 w-auto object-contain dark:brightness-110">
            </div>

            <h1
                class="text-3xl font-extrabold tracking-tight font-display text-slate-900 dark:text-white transition-all duration-500">
                Health Integration Portal
            </h1>
            <p
                class="mt-2 text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-widest text-balance">
                Pusat Layanan
                Kesehatan Digital Terintegrasi</p>

            @if ($appName)
                <div
                    class="mt-6 px-4 py-2 bg-teal-50/50 dark:bg-teal-900/20 backdrop-blur-sm border border-teal-100 dark:border-teal-800/50 rounded-xl inline-flex items-center gap-2 animate-fade-in transition-all duration-500">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                    </span>
                    <p class="text-sm font-medium text-teal-800 dark:text-teal-200">
                        Menghubungkan ke <span class="font-bold">{{ $appName }}</span>
                    </p>
                </div>
            @else
                <div
                    class="mt-6 px-4 py-2 bg-slate-50/80 dark:bg-slate-800/60 backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 rounded-xl inline-flex items-center gap-2 animate-fade-in transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4 text-slate-400 dark:text-slate-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-100 uppercase tracking-tighter">
                        Akses Portal Utama (Tanpa Konteks Aplikasi)
                    </p>
                </div>
            @endif
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-8 sm:p-10 rounded-[2.5rem] shadow-premium relative overflow-hidden border border-slate-200/60 dark:border-slate-800/60 transition-all duration-500">
            <!-- Subtle Decorative Health Element -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-teal-50 dark:bg-teal-900/10 rounded-full blur-3xl">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-48 h-48 bg-emerald-50 dark:bg-emerald-900/10 rounded-full blur-3xl">
            </div>

            @if ($step === 'login')
            <form wire:submit="authenticate" class="space-y-6 relative z-10">
                <div class="space-y-1.5 focus-within:z-20">
                    <label for="username" class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">
                        Nama Pengguna atau Email
                    </label>
                    <div class="relative flex items-center group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.113a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </div>
                        <input wire:model="username" id="username" type="text" autofocus
                            class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 outline-none shadow-sm group-hover:border-slate-400 dark:group-hover:border-slate-600"
                            placeholder="username / email@health.id">
                    </div>
                    @error('username')
                        <span class="block px-1 text-xs font-bold text-red-600 dark:text-red-400 mt-1 animate-shake">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-3.5 h-3.5 inline mr-1 -mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="space-y-1.5 focus-within:z-20">
                    <div class="flex items-center justify-between px-1">
                        <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                            Kata Sandi
                        </label>
                        <a href="{{ route('password.request') }}"
                            class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300 transition-all uppercase tracking-wider underline-offset-4 hover:underline">
                            Lupa?
                        </a>
                    </div>
                    <div class="relative flex items-center group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 10.5h13.5c.621 0 1.125-.504 1.125-1.125V11.25c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125v8.125c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <input wire:model="password" id="password" type="password"
                            class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 outline-none shadow-sm group-hover:border-slate-400 dark:group-hover:border-slate-600"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <span class="block px-1 text-xs font-bold text-red-600 dark:text-red-400 mt-1 animate-shake">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-3.5 h-3.5 inline mr-1 -mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="flex items-center px-1">
                    <div class="flex items-center cursor-pointer group">
                        <input wire:model="remember" id="remember_me" type="checkbox"
                            class="w-5 h-5 rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-teal-600 focus:ring-teal-500/20 transition-all cursor-pointer">
                        <label for="remember_me"
                            class="ml-3 text-sm font-bold text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white transition-colors cursor-pointer">
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

                        <span
                            class="relative z-10 flex items-center justify-center gap-3 tracking-wide uppercase text-sm">
                            <span wire:loading.remove wire:target="authenticate">Masuk Ke Akun</span>
                            <span wire:loading wire:target="authenticate">Memverifikasi...</span>

                            <svg wire:loading wire:target="authenticate" class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-100" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>

                            <svg wire:loading.remove wire:target="authenticate" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                                class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
            @else
            <form wire:submit="verifyTwoFactor" class="space-y-6 relative z-10 animate-fade-in">
                <div class="text-center mb-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 10.5h13.5c.621 0 1.125-.504 1.125-1.125V11.25c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125v8.125c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Verifikasi Dua Langkah (2FA)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Masukkan kode 6-digit dari aplikasi authenticator di ponsel Anda, atau gunakan salah satu Recovery Code.
                    </p>
                </div>

                <div class="space-y-1.5 focus-within:z-20">
                    <label for="twoFactorCode" class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">
                        Kode Otentikasi / Recovery Code
                    </label>
                    <div class="relative flex items-center group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a1.5 1.5 0 0 1 1.5 1.5v.008" />
                            </svg>
                        </div>
                        <input wire:model="twoFactorCode" id="twoFactorCode" type="text" autofocus autocomplete="one-time-code"
                            class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 outline-none shadow-sm text-center text-lg tracking-widest font-mono"
                            placeholder="123456">
                    </div>
                    @error('twoFactorCode')
                        <span class="block px-1 text-xs font-bold text-red-600 dark:text-red-400 mt-1 animate-shake">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="pt-2 space-y-3">
                    <button type="submit"
                        class="relative w-full py-4 px-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-2xl shadow-lg active:scale-[0.98] transition-all duration-300 flex justify-center items-center">
                        <span wire:loading.remove wire:target="verifyTwoFactor">Verifikasi & Masuk</span>
                        <span wire:loading wire:target="verifyTwoFactor">Memverifikasi...</span>
                    </button>

                    <button type="button" wire:click="backToLogin"
                        class="w-full py-2.5 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 uppercase tracking-wider transition-colors">
                        Kembali ke login
                    </button>
                </div>
            </form>
            @endif
        </div>

        <div class="mt-10 flex flex-col items-center gap-4">
            <p class="text-center text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                &copy; {{ date('Y') }} Layanan Kesehatan Digital. Pelayanan Berkualitas & Profesional.
            </p>
        </div>
    </div>
</div>
