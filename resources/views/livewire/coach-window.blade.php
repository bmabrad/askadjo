<div
    x-data="{ coaching: false, pendingText: null, pendingScreenshots: [] }"
    @coaching-started.window="coaching = true; pendingText = $event.detail?.text || null; pendingScreenshots = $event.detail?.screenshots || []; $nextTick(() => { $refs.chatContainer && ($refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight) })"
    @coaching-session-created.window="coaching = false; pendingText = null; pendingScreenshots = []"
    x-init="$nextTick(() => { $refs.chatContainer && ($refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight) })"
>
    {{-- Chat Thread --}}
    <div x-ref="chatContainer" style="overflow-y:auto;padding-bottom:1rem">
        @if($sessions->isEmpty())
            {{-- Welcome Message (coach bubble, left-aligned) --}}
            <div style="margin:2rem 0;display:flex;justify-content:flex-start">
                <div style="padding:1rem;background:var(--coach-bubble);border:1px solid var(--coach-bubble-border);border-radius:16px 16px 16px 4px;max-width:85%">
                    <p style="margin:0;font-size:0.9375rem;line-height:1.5;color:var(--text-primary)">Paste your first conversation to get started.</p>
                </div>
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

                {{-- User Bubble (right-aligned) --}}
                <div style="display:flex;justify-content:flex-end;margin-bottom:0.75rem">
                    <div style="max-width:80%">
                        <div style="padding:0.875rem 1rem;background:var(--bg-input);border-radius:16px 16px 4px 16px">
                            @if($session->input_type === \App\Enums\InputType::Screenshot && $session->screenshot_path)
                                <div x-data="{ lightbox: false, current: 0 }">
                                    <div style="display:flex;gap:0.375rem;flex-wrap:wrap">
                                        @foreach($session->screenshot_path as $index => $path)
                                            <img
                                                src="{{ route('screenshots.show', $path) }}"
                                                alt="Screenshot {{ $index + 1 }}"
                                                style="width:56px;height:56px;object-fit:cover;border-radius:8px;cursor:pointer;flex-shrink:0"
                                                @click="current = {{ $index }}; lightbox = true"
                                            >
                                        @endforeach
                                    </div>
                                    {{-- Lightbox --}}
                                    <div
                                        x-show="lightbox"
                                        x-cloak
                                        @click.self="lightbox = false"
                                        @keydown.escape.window="lightbox = false"
                                        style="position:fixed;inset:0;z-index:50;background:rgba(0,0,0,0.9);display:flex;align-items:center;justify-content:center;padding:1rem"
                                        x-transition
                                    >
                                        <button @click="lightbox = false" style="position:absolute;top:1rem;right:1rem;background:none;border:none;color:white;font-size:1.5rem;cursor:pointer;z-index:51">&times;</button>
                                        @if(count($session->screenshot_path) > 1)
                                            <button @click="current = (current - 1 + {{ count($session->screenshot_path) }}) % {{ count($session->screenshot_path) }}" style="position:absolute;left:0.5rem;background:rgba(255,255,255,0.2);border:none;color:white;font-size:1.5rem;padding:0.5rem 0.75rem;border-radius:50%;cursor:pointer">&#8249;</button>
                                            <button @click="current = (current + 1) % {{ count($session->screenshot_path) }}" style="position:absolute;right:0.5rem;background:rgba(255,255,255,0.2);border:none;color:white;font-size:1.5rem;padding:0.5rem 0.75rem;border-radius:50%;cursor:pointer">&#8250;</button>
                                        @endif
                                        @foreach($session->screenshot_path as $index => $path)
                                            <img
                                                x-show="current === {{ $index }}"
                                                src="{{ route('screenshots.show', $path) }}"
                                                alt="Screenshot {{ $index + 1 }}"
                                                style="max-width:100%;max-height:90vh;object-fit:contain;border-radius:8px"
                                            >
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($session->raw_text)
                                <p style="margin:0;font-size:0.9375rem;line-height:1.5;color:var(--text-primary);white-space:pre-line">{{ Str::limit($session->raw_text, 200) }}</p>
                            @endif
                        </div>
                        {{-- Contact label below user bubble --}}
                        <div style="text-align:right;margin-top:0.25rem;padding-right:0.25rem">
                            <span style="font-size:0.6875rem;color:var(--text-secondary)">
                                {{ $session->contact?->name ?? 'Unknown' }}
                                @if($session->contact?->platform && $session->contact->platform !== \App\Enums\Platform::Other)
                                    · {{ $session->contact->platform->name }}
                                @endif
                            </span>
                            <span style="font-size:0.6875rem;color:var(--text-muted);margin-left:0.375rem">{{ $session->created_at->diffForHumans(short: true) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Coach Bubble (left-aligned) --}}
                <div style="display:flex;justify-content:flex-start;margin-bottom:1.25rem">
                    <div style="max-width:85%">
                        <livewire:coaching-result :session="$session" :key="'session-'.$session->id" />
                    </div>
                </div>
            @endforeach

            {{-- Name Prompt (coach bubble, left-aligned) --}}
            @if($pendingNameSessionId)
                <div style="display:flex;justify-content:flex-start;margin-bottom:0.75rem">
                    <div style="padding:1rem;background:var(--coach-bubble);border:1px solid var(--coach-bubble-border);border-radius:16px 16px 16px 4px;max-width:85%">
                        <p style="margin:0;font-size:0.9375rem;line-height:1.5;color:var(--text-primary)">Who's this conversation with? Just a first name so I can keep track.</p>
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;margin-bottom:0.75rem">
                    <div style="max-width:80%">
                        <div style="display:flex;gap:0.5rem">
                            <input
                                type="text"
                                wire:model="nameInput"
                                wire:keydown.enter="submitName"
                                placeholder="Their name..."
                                style="flex:1;height:44px;padding:0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none"
                            >
                            <button wire:click="submitName" style="height:44px;padding:0 1rem;font-size:0.875rem;font-weight:600;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;border-radius:8px;cursor:pointer">Send</button>
                        </div>
                        @error('nameInput') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
                    </div>
                </div>
            @endif
        @endif

        {{-- Optimistic User Bubble (right-aligned, shown immediately on submit) --}}
        <template x-if="coaching && (pendingText || pendingScreenshots.length > 0)">
            <div style="display:flex;justify-content:flex-end;margin-bottom:0.75rem">
                <div style="max-width:80%">
                    <div style="padding:0.875rem 1rem;background:var(--bg-input);border-radius:16px 16px 4px 16px">
                        <template x-if="pendingScreenshots.length > 0">
                            <div style="display:flex;gap:0.375rem;flex-wrap:wrap">
                                <template x-for="(src, i) in pendingScreenshots" :key="i">
                                    <img :src="src" style="width:56px;height:56px;object-fit:cover;border-radius:8px;flex-shrink:0" alt="Screenshot">
                                </template>
                            </div>
                        </template>
                        <template x-if="pendingText">
                            <p style="margin:0;font-size:0.9375rem;line-height:1.5;color:var(--text-primary);white-space:pre-line" x-text="pendingText.substring(0, 200) + (pendingText.length > 200 ? '…' : '')"></p>
                        </template>
                    </div>
                    <div style="text-align:right;margin-top:0.25rem;padding-right:0.25rem">
                        <span style="font-size:0.6875rem;color:var(--text-muted)">just now</span>
                    </div>
                </div>
            </div>
        </template>

        {{-- Typing Indicator (coach bubble, left-aligned, client-side Alpine state) --}}
        <div
            x-show="coaching"
            x-cloak
            style="display:flex;justify-content:flex-start;margin-bottom:0.75rem"
        >
            <div style="padding:1rem;background:var(--coach-bubble);border:1px solid var(--coach-bubble-border);border-radius:16px 16px 16px 4px">
                <div style="display:flex;gap:0.375rem">
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--text-muted);animation:pulse 1.4s ease-in-out infinite"></span>
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--text-muted);animation:pulse 1.4s ease-in-out 0.2s infinite"></span>
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--text-muted);animation:pulse 1.4s ease-in-out 0.4s infinite"></span>
                </div>
            </div>
        </div>
        <style>@keyframes pulse{0%,100%{opacity:.3}50%{opacity:1}}</style>
    </div>

    {{-- Input Bar --}}
    <div style="margin-top:1rem;padding-top:0.75rem;border-top:1px solid var(--border)">
        <livewire:coach-input :chatMode="true" />
    </div>
</div>
