<?php

namespace App\Livewire;

use App\Models\Contact;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ContactThread extends Component
{
    public Contact $contact;
    public $sessions;

    public function mount(Contact $contact): void
    {
        Gate::authorize('view', $contact);

        $this->contact = $contact;
        $this->loadSessions();
    }

    #[On('coaching-session-created')]
    public function refreshSessions(): void
    {
        $this->loadSessions();
    }

    protected function loadSessions(): void
    {
        $this->sessions = $this->contact
            ->coachingSessions()
            ->orderBy('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.contact-thread');
    }
}
