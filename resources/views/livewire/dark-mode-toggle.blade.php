<div
    x-data="{
        isDark: @entangle('darkMode').live,
        announcement: '',
        init() {
            this.isDark = document.documentElement.classList.contains('dark');
        },
        toggleTheme() {
            this.isDark = !this.isDark;
            document.documentElement.classList.toggle('dark', this.isDark);
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
            this.announcement = this.isDark ? 'Dark theme enabled' : 'Light theme enabled';
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: this.isDark } }));
        }
    }"
    @theme-changed.window="isDark = $event.detail.isDark; document.documentElement.classList.toggle('dark', isDark);"
    @storage.window="if ($event.key === 'theme') { isDark = $event.newValue === 'dark'; document.documentElement.classList.toggle('dark', isDark); }"
    class="inline-flex items-center"
>
    <button
        type="button"
        @click="toggleTheme()"
        class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center gap-2 rounded-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-xs transition hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-950 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-950"
        :aria-label="isDark ? 'Switch to light theme' : 'Switch to dark theme'"
        :title="isDark ? 'Switch to light theme' : 'Switch to dark theme'"
        aria-label="Switch theme"
    >
        <!-- Sun icon (shown in dark mode) -->
        <svg
            x-show="isDark"
            x-cloak
            class="h-4 w-4 text-amber-400"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            aria-hidden="true"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>

        <!-- Moon icon (shown in light mode) -->
        <svg
            x-show="!isDark"
            class="h-4 w-4 text-slate-700 dark:text-slate-300"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            aria-hidden="true"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>

        <span x-text="isDark ? 'Light' : 'Dark'" class="hidden sm:inline font-semibold" aria-hidden="true"></span>
        <span class="sr-only" x-text="isDark ? 'Switch to light theme' : 'Switch to dark theme'"></span>
    </button>
    <div class="sr-only" role="status" aria-live="polite" x-text="announcement"></div>
</div>
