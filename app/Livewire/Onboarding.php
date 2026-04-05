<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.onboarding')]
class Onboarding extends Component
{
    public function mount(): void
    {
        if (auth()->user()->has_seen_onboarding) {
            $this->redirect(route('strat-chat'));
        }
    }

    public function complete(): void
    {
        auth()->user()->update(['has_seen_onboarding' => true]);
        $this->redirect(route('strat-chat'));
    }

    public function render()
    {
        return view('livewire.onboarding');
    }
}
