<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DarkModeToggle extends Component
{
    public bool $darkMode = false;

    public function mount(): void
    {
        if (Auth::check()) {
            $this->darkMode = (bool) Auth::user()->dark_mode;
        }
    }

    public function updatedDarkMode(): void
    {
        if (Auth::check()) {
            Auth::user()->update(['dark_mode' => $this->darkMode]);
        }
    }

    public function render()
    {
        return view('livewire.dark-mode-toggle');
    }
}
