<div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8 text-slate-900 dark:text-white">
    <div class="w-full max-w-[460px] animate-fade-in-up">
        <!-- Brand/Logo Area -->
        <div class="mb-10 text-center">
            <div class="flex items-center justify-center gap-6 mb-6">
                <img src="{{ asset('images/jakarta_logo.png') }}" alt="DKI Jakarta" class="h-10 w-auto object-contain">
                <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                <img src="{{ asset('images/jaksehat_logo.png') }}" alt="JakSehat" class="h-10 w-auto object-contain">
                <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                <img src="{{ asset('images/tarakan_logo.png') }}" alt="Tarakan" class="h-12 w-auto object-contain">
            </div>

            <h1 class="text-2xl font-bold tracking-tight font-display text-slate-900 dark:text-white">Pulihkan Kata
                Sandi</h1>
            <p
                class="mt-2 text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-widest text-balance">
                Masukkan email
                untuk menerima tautan reset</p>
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-8 sm:p-10 rounded-[2.5rem] shadow-premium relative overflow-hidden border border-slate-200/60 dark:border-slate-800/60">
            <!-- Subtle Decorative Health Element -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-teal-50 dark:bg-teal-900/10 rounded-full blur-3xl">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-48 h-48 bg-emerald-50 dark:bg-emerald-900/10 rounded-full blur-3xl">
            </div>

            @if ($status)
                <div
                    class="mb-6 p-4 bg-teal-50 dark:bg-teal-900/30 border border-teal-100 dark:border-teal-800 rounded-2xl flex items-center gap-3 text-teal-800 dark:text-teal-200 animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p class="text-sm font-bold">{{ $status }}</p>
                </div>
            @endif

            <form wire:submit="sendResetLink" class="space-y-6 relative z-10">
                <div class="space-y-1.5 focus-within:z-20">
                    <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">
                        Alamat Email
                    </label>
                    <div class="relative flex items-center group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input wire:model="email" id="email" type="email" autofocus
                            class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 outline-none shadow-sm group-hover:border-slate-400 dark:group-hover:border-slate-600"
                            placeholder="email@rsudtarakan.id">
                    </div>
                    @error('email')
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

                <div class="pt-2">
                    <button type="submit"
                        class="relative w-full py-4 px-4 bg-slate-900 dark:bg-teal-600 hover:bg-slate-800 dark:hover:bg-teal-500 text-white font-bold rounded-2xl shadow-lg active:scale-[0.98] transition-all duration-300 flex justify-center items-center overflow-hidden group">
                        <span
                            class="relative z-10 flex items-center justify-center gap-3 tracking-wide uppercase text-sm">
                            <span wire:loading.remove wire:target="sendResetLink">Kirim Tautan Pemulihan</span>
                            <span wire:loading wire:target="sendResetLink">Mengirim...</span>

                            <svg wire:loading wire:target="sendResetLink" class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-100" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-10 flex flex-col items-center gap-4">
            <p class="text-center text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                &copy; {{ date('Y') }} Layanan Kesehatan Digital. Pelayanan Berkualitas & Profesional.
            </p>
        </div>
    </div>
</div>
