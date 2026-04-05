<div>
    @if($session->situation_read)
        {{-- THE READ card --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-card);border-radius:12px;margin-bottom:8px">
            <div style="padding:10px 14px">
                <span style="font-size:10px;font-weight:700;color:var(--brand-gold);text-transform:uppercase;letter-spacing:1px">THE READ</span>
            </div>
            <div style="padding:0 14px 12px">
                <p style="margin:0;font-size:12px;line-height:1.5;color:var(--text-secondary)">{{ $session->situation_read }}</p>

                {{-- Principle Pills --}}
                @if($session->applicable_principles && count($session->applicable_principles) > 0)
                    <div style="display:flex;flex-wrap:wrap;gap:0.375rem;margin-top:10px">
                        @foreach($session->applicable_principles as $principle)
                            <span style="background:var(--pill-bg);border:1px solid var(--pill-border);border-radius:20px;padding:0.25rem 0.625rem;font-size:0.6875rem;color:var(--pill-text)">{{ $principle }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- SEND THIS card --}}
        @if($session->reply_options && count($session->reply_options) > 0)
            @php $primary = $session->reply_options[0]; @endphp
            <div style="background:var(--bg-card);border:1px solid var(--brand-gold);border-radius:12px;margin-bottom:8px">
                <div style="padding:10px 14px">
                    <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--icon-color)">SEND THIS</span>
                </div>
                <div style="padding:0 14px 14px">
                    <p style="margin:0;font-size:14px;font-weight:500;line-height:1.5;color:var(--text-primary)">{{ $primary['text'] }}</p>

                    {{-- Action buttons --}}
                    <div x-data="{ copied: false }" style="display:flex;gap:8px;margin-top:10px">
                        <button
                            data-text="{{ $primary['text'] }}"
                            @click="navigator.clipboard.writeText($el.dataset.text); copied = true; setTimeout(() => copied = false, 2000)"
                            style="padding:6px 14px;font-size:11px;font-weight:600;border:none;border-radius:8px;cursor:pointer;background:var(--brand-gold);color:var(--user-bubble-text)"
                        >
                            <span x-show="!copied">Copy</span>
                            <span x-show="copied" x-cloak>Copied!</span>
                        </button>
                        @if(count($session->reply_options) > 1)
                            <button
                                wire:click="toggleOptions"
                                style="padding:6px 14px;font-size:11px;font-weight:600;background:transparent;border:1px solid var(--text-muted);border-radius:8px;cursor:pointer;color:var(--text-muted)"
                            >More Options</button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Alternative reply cards (expanded via More Options) --}}
            @if($showOptions && count($session->reply_options) > 1)
                @foreach(array_slice($session->reply_options, 1) as $index => $option)
                    <div x-data="{ copied: false }" style="background:var(--bg-card);border:1px solid var(--border-card);border-radius:12px;margin-bottom:8px">
                        <div style="padding:10px 14px">
                            <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--icon-color)">OPTION {{ $index + 2 }}</span>
                        </div>
                        <div style="padding:0 14px 14px">
                            <p style="margin:0;font-size:14px;font-weight:500;line-height:1.5;color:var(--text-primary)">{{ $option['text'] }}</p>
                            <div style="margin-top:10px">
                                <button
                                    data-text="{{ $option['text'] }}"
                                    @click="navigator.clipboard.writeText($el.dataset.text); copied = true; setTimeout(() => copied = false, 2000)"
                                    style="padding:6px 14px;font-size:11px;font-weight:600;border:none;border-radius:8px;cursor:pointer;background:var(--brand-gold);color:var(--user-bubble-text)"
                                >
                                    <span x-show="!copied">Copy</span>
                                    <span x-show="copied" x-cloak>Copied!</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif

        {{-- WHY THIS WORKS card --}}
        @if($session->reply_options && count($session->reply_options) > 0)
            <div style="background:var(--bg-card);border:1px solid var(--border-card);border-radius:12px">
                <button
                    wire:click="toggleWhy"
                    style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:none;border:none;cursor:pointer"
                >
                    <span style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px">WHY THIS WORKS</span>
                    <span style="font-size:14px;color:var(--text-muted)">{!! $showWhy ? '&#9662;' : '&#9656;' !!}</span>
                </button>
                @if($showWhy)
                    <div style="padding:0 14px 12px">
                        @foreach($session->reply_options as $option)
                            @if(isset($option['why']))
                                <p style="margin:0 0 8px;font-size:11px;font-style:italic;line-height:1.5;color:var(--text-muted)">
                                    @if(isset($option['strategy']))
                                        <span style="font-style:normal;font-weight:600">{{ $option['strategy'] }}:</span>
                                    @endif
                                    {{ $option['why'] }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @else
        {{-- Error State --}}
        <div style="padding:12px 16px;background:var(--bg-card);border:1px solid var(--border-card);border-radius:12px">
            <p style="margin:0 0 0.75rem;font-size:13px;line-height:1.5;color:var(--text-secondary)">Couldn't analyse that one. Try a cleaner screenshot or paste the text instead.</p>
            <button
                wire:click="$dispatch('retry-coaching', { contactId: {{ $session->contact_id }} })"
                style="padding:0.5rem 1rem;font-size:0.875rem;font-weight:600;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;border-radius:8px;cursor:pointer"
            >Try Again</button>
        </div>
    @endif
</div>
