<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class PlaceholderPage extends Component
{
    public string $title = '';

    public function mount(): void
    {
        $routeName = request()->route()?->getName() ?? '';
        $this->title = Str::of($routeName)->replace('-', ' ')->title()->toString();
    }

    public function render()
    {
        return view('livewire.placeholder-page');
    }
}
