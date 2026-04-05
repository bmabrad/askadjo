<div>
    @include('partials.page-header', ['title' => 'Quick Reference'])

    {{-- Intro Text (visible on card 0) --}}
    <div style="margin-bottom:1rem;{{ $currentCard > 0 ? 'display:none' : '' }}">
        <p style="font-size:13px;color:var(--text-muted);text-align:center">Swipe through. Glance in 5 seconds. Get back to the conversation.</p>
    </div>

    {{-- Card Container --}}
    <div
        x-data="{
            currentCard: @entangle('currentCard'),
            startX: 0,
            deltaX: 0,
            swiping: false,
            next() { if (this.currentCard < 7) { $wire.nextCard(); } },
            prev() { if (this.currentCard > 0) { $wire.prevCard(); } }
        }"
        x-on:keydown.arrow-right.window="next()"
        x-on:keydown.arrow-left.window="prev()"
        x-on:touchstart="startX = $event.touches[0].clientX; swiping = true"
        x-on:touchmove="if (swiping) deltaX = $event.touches[0].clientX - startX"
        x-on:touchend="if (swiping && Math.abs(deltaX) > 50) { deltaX < 0 ? next() : prev(); } deltaX = 0; swiping = false"
        style="position:relative;overflow:hidden;min-height:400px"
    >
        @php
            $cards = [
                [
                    'title' => 'The One Rule',
                    'type' => 'callout',
                    'content' => '"The goal is not for her to wonder if you like her. It\'s for her to wonder why you don\'t like her more."',
                ],
                [
                    'title' => 'The 4 Frames',
                    'type' => 'numbered',
                    'items' => [
                        'Am I evaluating her, or auditioning for her?',
                        'Am I challenging, or just agreeing with everything?',
                        'Am I showing how hard I\'m trying?',
                        'Am I believing my own excuses?',
                    ],
                ],
                [
                    'title' => 'The 10 Triggers',
                    'type' => 'tiers',
                    'tiers' => [
                        ['label' => 'S-TIER:', 'items' => 'Preselection, Being a Challenge'],
                        ['label' => 'A-TIER:', 'items' => 'Confidence, Status, Social Intuition, Leadership'],
                        ['label' => 'B-TIER:', 'items' => 'Humour, Intelligence, Fitness, Money'],
                    ],
                    'footer' => "You don't need all 10. You need your top 3 to be strong.",
                ],
                [
                    'title' => 'The Text Rules',
                    'type' => 'two-column',
                    'left' => [
                        '1. Statements over questions',
                        '2. Drop the question mark',
                        '3. Keep it short, 2 lines max',
                        '4. Never reply instantly',
                        '5. End convos first, at the peak',
                    ],
                    'right' => [
                        '6. Embed triggers subtly',
                        '7. Create ambiguity',
                        '8. Never profess feelings first',
                        '9. No response? No ego.',
                        "10. Check she's free before inviting",
                    ],
                ],
                [
                    'title' => 'The Reframing Formula',
                    'type' => 'reframe',
                    'intro' => 'Always choose the interpretation that moves things forward. Then:',
                    'steps' => [
                        ['title' => 'VALIDATE', 'desc' => 'Make her feel heard.'],
                        ['title' => 'REDIRECT', 'desc' => 'Shift to a better frame.'],
                        ['title' => 'ANCHOR', 'desc' => 'End with something she agrees with.'],
                    ],
                ],
                [
                    'title' => 'Emergency Reset',
                    'type' => 'arrows',
                    'intro' => 'Ask yourself these when the interaction is slipping:',
                    'items' => [
                        'Am I chasing right now?',
                        'Would I do this if I had 10 other options?',
                        'Am I trying to impress or evaluate?',
                        'How much effort am I showing?',
                        'Am I being the yes-man?',
                    ],
                ],
                [
                    'title' => 'The Compliment Rule',
                    'type' => 'text',
                    'paragraphs' => [
                        '<strong style="color:var(--text-primary)">Compliment what she earned,</strong> never what she was born with. She didn\'t work for her blue eyes. She\'s heard about them from a thousand guys. But if she became a nurse because she wanted to help people, that\'s something she invested in.',
                        'Fewer compliments, not more. Make her tell you something real first. Then reward it.',
                    ],
                ],
                [
                    'title' => 'Scarcity Reminders',
                    'type' => 'arrows',
                    'items' => [
                        '5-minute minimum before first reply. Could be hours. Be unpredictable.',
                        'End conversations at the high point, not the lull.',
                        '"Let me check my schedule", your time has value. Don\'t say yes instantly.',
                        'When you reply late, stack a trigger: "Was at the gym. What\'s up?"',
                        "Don't always be available. If you're always there, you have no value.",
                    ],
                ],
            ];
        @endphp

        @foreach($cards as $i => $card)
            <div
                x-show="currentCard === {{ $i }}"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-4"
                x-transition:enter-end="opacity-100 translate-x-0"
                style="background:var(--bg-card);border:1px solid var(--border-card);border-radius:12px;padding:14px 16px;margin:0 22px"
            >
                {{-- Card Title --}}
                <h3 style="font-size:14px;font-weight:700;color:var(--brand-gold-light);margin-bottom:12px">{{ $card['title'] }}</h3>

                @if($card['type'] === 'callout')
                    <p style="font-size:13px;font-weight:700;color:var(--text-primary);line-height:1.6;font-style:italic">{{ $card['content'] }}</p>

                @elseif($card['type'] === 'numbered')
                    @foreach($card['items'] as $j => $item)
                        <div style="display:flex;gap:10px;margin-bottom:8px">
                            <span style="color:var(--brand-gold);font-size:13px;font-weight:700;min-width:16px">{{ $j + 1 }}</span>
                            <span style="font-size:12px;color:var(--text-secondary);line-height:1.6">{{ $item }}</span>
                        </div>
                    @endforeach

                @elseif($card['type'] === 'tiers')
                    @foreach($card['tiers'] as $tier)
                        <div style="margin-bottom:8px">
                            <span style="font-size:12px;font-weight:600;color:var(--text-primary)">{{ $tier['label'] }}</span>
                            <span style="font-size:12px;color:var(--text-secondary)">{{ $tier['items'] }}</span>
                        </div>
                    @endforeach
                    <p style="font-size:11px;font-style:italic;color:var(--text-muted);margin-top:12px">{{ $card['footer'] }}</p>

                @elseif($card['type'] === 'two-column')
                    <div style="display:flex;gap:16px;flex-wrap:wrap">
                        <div style="flex:1;min-width:140px">
                            @foreach($card['left'] as $rule)
                                <p style="font-size:11px;color:var(--text-secondary);line-height:1.8;margin:0">{{ $rule }}</p>
                            @endforeach
                        </div>
                        <div style="flex:1;min-width:140px">
                            @foreach($card['right'] as $rule)
                                <p style="font-size:11px;color:var(--text-secondary);line-height:1.8;margin:0">{{ $rule }}</p>
                            @endforeach
                        </div>
                    </div>

                @elseif($card['type'] === 'reframe')
                    <p style="font-size:12px;color:var(--text-secondary);line-height:1.6;margin-bottom:12px">{{ $card['intro'] }}</p>
                    <div style="display:flex;gap:8px;flex-wrap:wrap">
                        @foreach($card['steps'] as $step)
                            <div style="flex:1;min-width:90px;background:var(--bg-screen);border:1px solid var(--border-card);border-radius:8px;padding:10px;text-align:center">
                                <div style="font-size:11px;font-weight:700;color:var(--text-primary);margin-bottom:4px">{{ $step['title'] }}</div>
                                <div style="font-size:10px;color:var(--text-secondary)">{{ $step['desc'] }}</div>
                            </div>
                        @endforeach
                    </div>

                @elseif($card['type'] === 'arrows')
                    @if(isset($card['intro']))
                        <p style="font-size:12px;color:var(--text-secondary);line-height:1.6;margin-bottom:10px">{{ $card['intro'] }}</p>
                    @endif
                    @foreach($card['items'] as $item)
                        <div style="display:flex;gap:8px;margin-bottom:8px">
                            <span style="color:var(--brand-gold);font-size:12px">&rarr;</span>
                            <span style="font-size:12px;color:var(--text-secondary);line-height:1.6">{{ $item }}</span>
                        </div>
                    @endforeach

                @elseif($card['type'] === 'text')
                    @foreach($card['paragraphs'] as $p)
                        <p style="font-size:12px;color:var(--text-secondary);line-height:1.6;margin-bottom:10px">{!! $p !!}</p>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>

    {{-- Dot Indicator --}}
    <div style="display:flex;justify-content:center;gap:8px;margin-top:1.25rem;padding-bottom:1rem">
        @for($i = 0; $i < 8; $i++)
            <span style="width:8px;height:8px;border-radius:50%;background:{{ $currentCard === $i ? 'var(--brand-gold)' : 'var(--border-card)' }};transition:background 200ms ease"></span>
        @endfor
    </div>
</div>
