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

            <h1 class="text-2xl font-bold tracking-tight font-display text-slate-900 dark:text-white">Buat Kata Sandi
                Baru</h1>
            <p
                class="mt-2 text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-widest text-balance">
                Amankan kembali
                akses akun Anda</p>
        </div>

        <div
            class="bg-white dark:bg-slate-900 p-8 sm:p-10 rounded-[2.5rem] shadow-premium relative overflow-hidden border border-slate-200/60 dark:border-slate-800/60">
            <!-- Subtle Decorative Health Element -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-teal-50 dark:bg-teal-900/10 rounded-full blur-3xl">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-48 h-48 bg-emerald-50 dark:bg-emerald-900/10 rounded-full blur-3xl">
            </div>

            <form wire:submit="resetPassword" class="space-y-6 relative z-10">
                <input type="hidden" wire:model="token">

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
                        <input wire:model="email" id="email" type="email" readonly
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-300 dark:border-slate-700 rounded-2xl text-slate-500 dark:text-slate-400 cursor-not-allowed outline-none">
                    </div>
                </div>

                <div class="space-y-1.5 focus-within:z-20">
                    <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">
                        Kata Sandi Baru
                    </label>
                    <div class="relative flex items-center group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 10.5h13.5c.621 0 1.125-.504 1.125-1.125V11.25c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125v8.125c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <input wire:model="password" id="password" type="password" autofocus
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

                <div class="space-y-1.5 focus-within:z-20">
                    <label for="passwordConfirmation"
                        class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <div class="relative flex items-center group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 10.5h13.5c.621 0 1.125-.504 1.125-1.125V11.25c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125v8.125c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <input wire:model="passwordConfirmation" id="passwordConfirmation" type="password"
                            class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all duration-300 outline-none shadow-sm group-hover:border-slate-400 dark:group-hover:border-slate-600"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="relative w-full py-4 px-4 bg-slate-900 dark:bg-teal-600 hover:bg-slate-800 dark:hover:bg-teal-500 text-white font-bold rounded-2xl shadow-lg active:scale-[0.98] transition-all duration-300 flex justify-center items-center overflow-hidden group">
                        <span
                            class="relative z-10 flex items-center justify-center gap-3 tracking-wide uppercase text-sm">
                            <span wire:loading.remove wire:target="resetPassword">Simpan Kata Sandi Baru</span>
                            <span wire:loading wire:target="resetPassword">Menyimpan...</span>

                            <svg wire:loading wire:target="resetPassword" class="animate-spin h-5 w-5 text-white"
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
            </form>
        </div>

        <div class="mt-10 flex flex-col items-center gap-4">
            <p class="text-center text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                &copy; {{ date('Y') }} Layanan Kesehatan Digital. Pelayanan Berkualitas & Profesional.
            </p>
        </div>
    </div>
</div>
