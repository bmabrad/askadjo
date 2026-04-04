<div>
    @if($session->situation_read)
        {{-- Coach Bubble --}}
        <div style="padding:1rem;background:var(--coach-bubble);border:1px solid var(--coach-bubble-border);border-radius:16px 16px 16px 4px">
            {{-- Situation Read (natural conversational text, no header) --}}
            <p style="margin:0 0 1rem;font-size:0.9375rem;line-height:1.6;color:var(--text-primary)">{{ $session->situation_read }}</p>

            {{-- Reply Suggestions --}}
            @if($session->reply_options && count($session->reply_options) > 0)
                <p style="margin:0 0 0.625rem;font-size:0.8125rem;color:var(--text-secondary)">Try one of these:</p>

                @foreach($session->reply_options as $index => $option)
                    <div x-data="{ copied: false }" style="display:flex;align-items:flex-start;gap:0.5rem;{{ $index > 0 ? 'margin-top:0.5rem' : '' }}">
                        <p style="flex:1;margin:0;font-size:0.9375rem;line-height:1.5;color:var(--text-primary)">{{ $option['text'] }}</p>
                        <button
                            data-text="{{ $option['text'] }}"
                            @click="navigator.clipboard.writeText($el.dataset.text); copied = true; setTimeout(() => copied = false, 2000)"
                            style="flex-shrink:0;padding:0.25rem 0.5rem;background:none;border:1px solid var(--border);border-radius:6px;color:var(--text-secondary);cursor:pointer;font-size:0.75rem;white-space:nowrap"
                        >
                            <span x-show="!copied">Copy</span>
                            <span x-show="copied" x-cloak style="color:var(--success)">Copied!</span>
                        </button>
                    </div>
                @endforeach
            @endif

            {{-- More toggle (principles + why explanations) --}}
            <div style="margin-top:0.875rem;display:flex;align-items:center;justify-content:space-between">
                {{-- Principle tags inline preview --}}
                @if($session->applicable_principles && count($session->applicable_principles) > 0)
                    <span style="font-size:0.6875rem;color:var(--text-muted)">
                        {{ implode(' · ', array_map(fn($p) => strtolower(str_replace(' ', '_', $p)), $session->applicable_principles)) }}
                    </span>
                @endif

                <button
                    wire:click="toggleMore"
                    style="background:none;border:none;color:var(--text-muted);font-size:0.8125rem;cursor:pointer;padding:0.25rem 0;display:flex;align-items:center;gap:0.25rem;margin-left:auto"
                >
                    <span style="display:inline-block;transition:transform 0.2s;{{ $showMore ? 'transform:rotate(90deg)' : '' }}">&#9656;</span>
                    More
                </button>
            </div>

            {{-- Expanded More section --}}
            @if($showMore)
                <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid var(--border)">
                    {{-- Principle Pills --}}
                    @if($session->applicable_principles && count($session->applicable_principles) > 0)
                        <div style="display:flex;flex-wrap:wrap;gap:0.375rem;margin-bottom:0.75rem">
                            @foreach($session->applicable_principles as $principle)
                                <span style="background:var(--pill-bg);border:1px solid var(--pill-border);border-radius:20px;padding:0.25rem 0.625rem;font-size:0.6875rem;color:var(--pill-text)">{{ $principle }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Per-reply Why explanations --}}
                    @if($session->reply_options && count($session->reply_options) > 0)
                        @foreach($session->reply_options as $index => $option)
                            <div style="{{ $index > 0 ? 'margin-top:0.5rem;' : '' }}">
                                <button
                                    wire:click="toggleWhy({{ $index }})"
                                    style="background:none;border:none;color:var(--text-muted);font-size:0.75rem;cursor:pointer;padding:0.25rem 0;display:flex;align-items:center;gap:0.25rem"
                                >
                                    <span style="display:inline-block;transition:transform 0.2s;{{ in_array($index, $expandedWhy) ? 'transform:rotate(90deg)' : '' }}">&#9656;</span>
                                    Why "{{ Str::limit($option['text'], 30) }}"?
                                </button>
                                @if(in_array($index, $expandedWhy))
                                    <p style="margin:0.25rem 0 0 1rem;font-size:0.8125rem;color:var(--text-secondary);line-height:1.5">
                                        @if(isset($option['strategy']))
                                            <span style="background:var(--pill-bg);border:1px solid var(--pill-border);border-radius:10px;padding:0.125rem 0.375rem;font-size:0.6875rem;color:var(--pill-text);margin-right:0.25rem">{{ $option['strategy'] }}</span>
                                        @endif
                                        {{ $option['why'] }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    @else
        {{-- Error State (coach bubble) --}}
        <div style="padding:1rem;background:var(--coach-bubble);border:1px solid var(--coach-bubble-border);border-radius:16px 16px 16px 4px">
            <p style="margin:0 0 0.75rem;font-size:0.9375rem;line-height:1.5;color:var(--text-secondary)">Couldn't analyse that one. Try a cleaner screenshot or paste the text instead.</p>
            <button
                wire:click="$dispatch('retry-coaching', { contactId: {{ $session->contact_id }} })"
                style="padding:0.5rem 1rem;font-size:0.875rem;font-weight:600;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;border-radius:8px;cursor:pointer"
            >Try Again</button>
        </div>
    @endif
</div>
