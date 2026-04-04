<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public string $search = '';

    public function render()
    {
        $contacts = Contact::where('user_id', auth()->id())
            ->active()
            ->with('latestCoachingSession')
            ->withMax('coachingSessions', 'created_at')
            ->orderByDesc('coaching_sessions_max_created_at')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->get();

        return view('livewire.dashboard', [
            'contacts' => $contacts,
        ]);
    }
}
