<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class ThemeSwitcher extends Component
{
    public string $theme = 'light';

    public function mount()
    {
        $this->theme = request()->cookie('theme', 'light');
    }

    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        Cookie()->queue('theme', $this->theme, 60 * 24 * 365);
    }

    public function render()
    {
        return view('livewire.auth.theme-switcher');
    }
}
