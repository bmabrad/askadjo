<div x-data="{ showMenu: false }" x-init="$nextTick(() => { $refs.threadContainer && ($refs.threadContainer.scrollTop = $refs.threadContainer.scrollHeight) })">
    {{-- Thread Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:center;gap:0.75rem">
            <a href="{{ route('strat-chat') }}" style="color:var(--text-secondary);text-decoration:none;font-size:1.25rem">&larr;</a>
            <div>
                <h1 style="font-size:1.125rem;font-weight:600;margin:0">{{ $contact->name }}</h1>
                <span style="font-size:0.75rem;color:var(--text-muted)">{{ $contact->platform->name }}</span>
            </div>
        </div>
        <div style="position:relative">
            <button @click="showMenu = !showMenu" style="background:none;border:none;color:var(--text-secondary);cursor:pointer;font-size:1.25rem;padding:0.25rem 0.5rem">&#8942;</button>
            <div x-show="showMenu" x-cloak @click.away="showMenu = false" style="position:absolute;right:0;top:100%;background:var(--bg-card);border:1px solid var(--border);border-radius:8px;min-width:160px;z-index:10;overflow:hidden">
                <button onclick="Livewire.dispatch('open-edit-modal', { contactId: {{ $contact->id }} })" @click="showMenu = false" style="display:block;width:100%;text-align:left;padding:0.625rem 1rem;background:none;border:none;color:var(--text-primary);cursor:pointer;font-size:0.875rem">Edit Contact</button>
                <form method="POST" action="{{ route('contacts.archive', $contact) }}">
                    @csrf @method('PATCH')
                    <button type="submit" @click="showMenu = false" style="display:block;width:100%;text-align:left;padding:0.625rem 1rem;background:none;border:none;color:var(--text-primary);cursor:pointer;font-size:0.875rem">Archive Contact</button>
                </form>
                <button onclick="Livewire.dispatch('open-delete-modal', { contactId: {{ $contact->id }} })" @click="showMenu = false" style="display:block;width:100%;text-align:left;padding:0.625rem 1rem;background:none;border:none;color:var(--error);cursor:pointer;font-size:0.875rem">Delete Contact</button>
            </div>
        </div>
    </div>

    {{-- Session Timeline --}}
    <div x-ref="threadContainer" style="overflow-y:auto;padding-bottom:1rem">
        @if($sessions->isEmpty())
            <div style="text-align:center;padding:3rem 1rem;color:var(--text-secondary)">
                <p style="font-size:0.9375rem;margin-bottom:0.5rem">No coaching sessions yet.</p>
                <p style="font-size:0.8125rem;color:var(--text-muted)">Upload a screenshot or paste your conversation with {{ $contact->name }} to get started.</p>
            </div>
        @else
            @php $lastDate = null; @endphp
            @foreach($sessions as $session)
                @php
                    $sessionDate = $session->created_at->format('Y-m-d');
                    $showDivider = $sessionDate !== $lastDate;
                    $lastDate = $sessionDate;
                @endphp

                @if($showDivider)
                    <div style="display:flex;align-items:center;gap:0.75rem;margin:1.25rem 0">
                        <div style="flex:1;height:1px;background:var(--border)"></div>
                        <span style="font-size:0.75rem;color:var(--text-muted);white-space:nowrap">
                            @if($session->created_at->isToday())
                                Today
                            @elseif($session->created_at->isYesterday())
                                Yesterday
                            @else
                                {{ $session->created_at->format('F j, Y') }}
                            @endif
                        </span>
                        <div style="flex:1;height:1px;background:var(--border)"></div>
                    </div>
                @endif

                <div style="margin-bottom:1.25rem">
                    <livewire:coaching-result :session="$session" :key="'session-'.$session->id" />
                </div>
            @endforeach
        @endif
    </div>

    {{-- Persistent Input Bar --}}
    <div style="margin-top:1rem;padding-top:0.75rem;border-top:1px solid var(--border)">
        <livewire:coach-input :contactId="$contact->id" />
    </div>
</div>
