<?php

namespace App\Livewire;

use App\Enums\Platform;
use App\Models\CoachingSession;
use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.app')]
class StratChat extends Component
{
    public $sessions;
    public ?int $pendingNameSessionId = null;
    public string $nameInput = '';

    public function mount(): void
    {
        $this->loadSessions();
        $this->checkPendingName();
    }

    #[On('coaching-session-created')]
    public function refreshSessions(int $sessionId): void
    {
        $this->isCoaching = false;
        $this->loadSessions();
        $this->checkPendingName();
    }

    public function submitName(): void
    {
        $this->validate([
            'nameInput' => ['required', 'string', 'max:255'],
        ]);

        if (! $this->pendingNameSessionId) {
            return;
        }

        $session = CoachingSession::whereHas('contact', fn ($q) => $q->where('user_id', auth()->id()))
            ->find($this->pendingNameSessionId);

        if (! $session) {
            return;
        }

        $name = trim($this->nameInput);

        // Match existing contact or rename the Unknown one
        $existing = auth()->user()->contacts()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->where('name', '!=', 'Unknown')
            ->first();

        if ($existing) {
            // Move session to the existing contact, clean up the Unknown placeholder
            $oldContact = $session->contact;
            $session->update(['contact_id' => $existing->id]);
            if ($oldContact->name === 'Unknown' && $oldContact->coachingSessions()->count() === 0) {
                $oldContact->delete();
            }
        } else {
            // Rename the placeholder contact
            $session->contact->update(['name' => $name]);
        }

        $this->nameInput = '';
        $this->pendingNameSessionId = null;
        $this->loadSessions();
    }

    protected function loadSessions(): void
    {
        $this->sessions = CoachingSession::with('contact')
            ->whereHas('contact', fn ($q) => $q->where('user_id', auth()->id()))
            ->orderBy('created_at')
            ->get();
    }

    protected function checkPendingName(): void
    {
        $this->pendingNameSessionId = null;

        if ($this->sessions->isEmpty()) {
            return;
        }

        $latest = $this->sessions->last();

        // Only prompt for name when this is the user's first ever session and the contact is Unknown
        if ($latest->contact
            && $latest->contact->name === 'Unknown'
            && $latest->situation_read
            && $this->sessions->count() === 1
        ) {
            $this->pendingNameSessionId = $latest->id;
        }
    }

    public function render()
    {
        return view('livewire.strat-chat');
    }
}
