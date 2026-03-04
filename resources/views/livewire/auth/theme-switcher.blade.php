<div x-data="{
    theme: @entangle('theme'),
}" x-init="// Initial theme setup based on localStorage or system preference
if (!localStorage.getItem('theme')) {
    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    theme = systemTheme;
} else {
    theme = localStorage.getItem('theme');
}"
    x-effect="if (theme === 'dark') {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark');
}
localStorage.setItem('theme', theme);"
    class="fixed top-6 right-6 z-50">
    <button @click="theme = (theme === 'light' ? 'dark' : 'light')"
        class="flex items-center justify-center p-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-premium hover:shadow-teal-500/10 transition-all duration-300 group overflow-hidden"
        title="Beralih Tema">

        <div class="relative w-6 h-6 flex items-center justify-center">
            <!-- Sun Icon (Transforms in Dark Mode) -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6 text-amber-500 transition-all duration-700 ease-spring"
                :class="theme === 'dark' ? 'rotate-[120deg] scale-0 opacity-0' : 'rotate-0 scale-100 opacity-100'">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591-1.591M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" />
            </svg>

            <!-- Moon Icon (Transforms in Light Mode) -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="absolute w-5 h-5 text-teal-400 transition-all duration-700 ease-spring"
                :class="theme === 'dark' ? 'rotate-0 scale-100 opacity-100' : '-rotate-[120deg] scale-0 opacity-0'">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.718 9.718 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
        </div>

        <span
            class="max-w-0 group-hover:max-w-xs overflow-hidden transition-all duration-700 ease-in-out whitespace-nowrap ml-0 group-hover:ml-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
            <span x-text="theme === 'light' ? 'Mode Gelap' : 'Mode Terang'"></span>
        </span>
    </button>
</div>
