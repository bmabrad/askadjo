<?php

namespace App\Livewire;

use App\Models\CoachingSession;
use Livewire\Component;

class CoachingResult extends Component
{
    public CoachingSession $session;
    public bool $showMore = false;
    public array $expandedWhy = [];

    public function mount(CoachingSession $session): void
    {
        $this->session = $session;
    }

    public function toggleMore(): void
    {
        $this->showMore = ! $this->showMore;
    }

    public function toggleWhy(int $index): void
    {
        if (in_array($index, $this->expandedWhy)) {
            $this->expandedWhy = array_values(array_diff($this->expandedWhy, [$index]));
        } else {
            $this->expandedWhy[] = $index;
        }
    }

    public function render()
    {
        return view('livewire.coaching-result');
    }
}
