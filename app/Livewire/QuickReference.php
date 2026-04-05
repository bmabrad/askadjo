<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class QuickReference extends Component
{
    public int $currentCard = 0;

    public function nextCard(): void
    {
        if ($this->currentCard < 7) {
            $this->currentCard++;
        }
    }

    public function prevCard(): void
    {
        if ($this->currentCard > 0) {
            $this->currentCard--;
        }
    }

    public function render()
    {
        return view('livewire.quick-reference');
    }
}
