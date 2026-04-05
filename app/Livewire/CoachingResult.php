<?php

namespace App\Livewire;

use App\Models\CoachingSession;
use Livewire\Component;

class CoachingResult extends Component
{
    public CoachingSession $session;
    public bool $showWhy = false;
    public bool $showOptions = false;

    public function mount(CoachingSession $session): void
    {
        $this->session = $session;
    }

    public function toggleWhy(): void
    {
        $this->showWhy = ! $this->showWhy;
    }

    public function toggleOptions(): void
    {
        $this->showOptions = ! $this->showOptions;
    }

    public function render()
    {
        return view('livewire.coaching-result');
    }
}
