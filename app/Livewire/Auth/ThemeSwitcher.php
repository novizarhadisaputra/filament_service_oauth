<?php

namespace App\Livewire\Auth;

use Livewire\Component;

/**
 * Class ThemeSwitcher
 *
 * Theme Switcher.
 */
class ThemeSwitcher extends Component
{
    public string $theme = 'light';

    /**
     * Execute Mount operation.
     */
    public function mount()
    {
        $this->theme = request()->cookie('theme', 'light');
    }

    /**
     * Execute Toggle Theme operation.
     */
    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        Cookie()->queue('theme', $this->theme, 60 * 24 * 365);
    }

    /**
     * Execute Render operation.
     */
    public function render()
    {
        return view('livewire.auth.theme-switcher');
    }
}
