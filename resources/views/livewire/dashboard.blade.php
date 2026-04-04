<div>
    {{-- Search Bar --}}
    <div style="margin-bottom:1rem;position:relative">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Search contacts..."
            style="width:100%;height:48px;padding:0 2.5rem 0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none"
        >
        @if($search)
            <button wire:click="$set('search', '')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:1rem">&times;</button>
        @endif
    </div>

    @if($contacts->isEmpty() && !$search)
        {{-- Empty State: New User --}}
        <div style="text-align:center;padding:3rem 1rem">
            <h2 style="font-size:1.25rem;font-weight:700;margin-bottom:0.75rem">Welcome to Collaborate.ai</h2>
            <p style="color:var(--text-secondary);font-size:0.9375rem;line-height:1.6;margin-bottom:1.5rem">
                Screenshot a conversation.<br>
                Get coached.<br>
                Copy and send.
            </p>
            <button
                onclick="Livewire.dispatch('open-create-modal')"
                style="padding:0.75rem 1.5rem;font-size:1rem;font-weight:600;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;border-radius:8px;cursor:pointer"
            >Start Your First Session</button>
        </div>
    @elseif($contacts->isEmpty() && $search)
        {{-- No Search Results --}}
        <div style="text-align:center;padding:2rem 1rem;color:var(--text-secondary)">
            <p style="font-size:0.9375rem">No contacts matching '{{ $search }}'.</p>
        </div>
    @else
        {{-- Contact List --}}
        <div style="display:flex;flex-direction:column;gap:0.5rem">
            @foreach($contacts as $contact)
                <a href="{{ route('contacts.show', $contact) }}" style="display:block;text-decoration:none;color:inherit;padding:0.875rem 1rem;background:var(--bg-card);border:1px solid var(--border);border-radius:8px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.25rem">
                        <span style="font-weight:600;font-size:0.9375rem;color:var(--text-primary)">{{ $contact->name }}</span>
                        <span style="font-size:0.75rem;color:var(--text-muted)">{{ $contact->platform->name }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <span style="font-size:0.8125rem;color:var(--text-secondary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:70%">
                            @if($contact->latestCoachingSession?->situation_read)
                                {{ Str::limit($contact->latestCoachingSession->situation_read, 60) }}
                            @else
                                No coaching yet
                            @endif
                        </span>
                        @if($contact->coaching_sessions_max_created_at)
                            <span style="font-size:0.75rem;color:var(--text-muted);flex-shrink:0">{{ \Carbon\Carbon::parse($contact->coaching_sessions_max_created_at)->diffForHumans(short: true) }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    {{-- New Conversation FAB --}}
    @if($contacts->isNotEmpty() || $search)
        <div style="position:fixed;bottom:1.5rem;right:1.5rem;z-index:20">
            <button
                onclick="Livewire.dispatch('open-create-modal')"
                style="width:56px;height:56px;border-radius:50%;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;font-size:1.5rem;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center"
            >+</button>
        </div>
    @endif

    <livewire:create-contact-modal />
</div>
