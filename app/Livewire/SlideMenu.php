<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class SlideMenu extends Component
{
    public bool $open = false;
    public string $currentTheme = 'dark';

    public function mount(): void
    {
        $this->currentTheme = auth()->user()->theme ?? 'dark';
    }

    #[On('toggle-slide-menu')]
    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function toggleTheme(): void
    {
        $this->currentTheme = $this->currentTheme === 'dark' ? 'light' : 'dark';

        auth()->user()->update(['theme' => $this->currentTheme]);

        $this->dispatch('theme-changed', theme: $this->currentTheme);
    }

    public function render()
    {
        return view('livewire.slide-menu');
    }
}
