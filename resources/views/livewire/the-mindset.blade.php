<div>
    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:center;gap:0.75rem">
            <a href="javascript:history.back()" style="color:var(--text-secondary);text-decoration:none;font-size:1.25rem">&larr;</a>
            <h1 style="font-size:1.25rem;font-weight:700;margin:0;color:var(--text-primary)">The Mindset</h1>
        </div>
        <a href="{{ route('strat-chat') }}" style="color:var(--close-color, #8C7A5E);text-decoration:none;font-size:1.25rem">&times;</a>
    </div>

    {{-- Scrollable Content --}}
    <div style="padding-bottom:3rem">

        {{-- Section 1: The One Rule --}}
        <div style="background:var(--bg-card);border-left:3px solid var(--brand-gold);border-radius:0 10px 10px 0;padding:14px 16px;margin-bottom:1.25rem">
            <p style="color:var(--brand-gold-light);font-style:italic;font-size:13px;line-height:1.6;margin:0">"The goal is not for her to wonder if you like her. It's for her to wonder why you don't like her more."</p>
        </div>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:2rem">Everything the app does comes back to that line. When you're chasing, your flaws magnify. When she's chasing, your flaws disappear. Same two people, different dynamic.</p>

        {{-- Section 2: The 4 Frames --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE 4 FRAMES</h2>

        @php
            $frames = [
                ['title' => 'Be the evaluator, not the applicant.', 'body' => 'Your question should be "is she interesting enough for me?" not "how do I get her to like me?"'],
                ['title' => 'Challenging beats nice.', 'body' => 'A conversation where you just nod and agree is the most boring interaction possible.'],
                ['title' => 'Low visible effort.', 'body' => "Put in the work. Never advertise it. If you wouldn't tell your mate how hard you tried, don't tell her."],
                ['title' => 'No limiting beliefs.', 'body' => 'Height, race, income, none of these are the variable. Your approach is.'],
            ];
        @endphp

        @foreach($frames as $i => $frame)
            <div style="display:flex;gap:12px;margin-bottom:1rem">
                <span style="color:var(--brand-gold);font-size:14px;font-weight:700;min-width:18px">{{ $i + 1 }}</span>
                <p style="font-size:13px;line-height:1.6;margin:0"><span style="color:var(--text-primary);font-weight:600">{{ $frame['title'] }}</span> <span style="color:var(--text-secondary)">{{ $frame['body'] }}</span></p>
            </div>
        @endforeach

        <div style="margin-bottom:2rem"></div>

        {{-- Section 3: The 10 Triggers --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE 10 TRIGGERS</h2>

        @php
            $triggers = [
                ['tier' => 'S', 'name' => 'Preselection'],
                ['tier' => 'S', 'name' => 'Being a Challenge'],
                ['tier' => 'A', 'name' => 'Confidence'],
                ['tier' => 'A', 'name' => 'Status'],
                ['tier' => 'A', 'name' => 'Social Intuition'],
                ['tier' => 'A', 'name' => 'Leadership'],
                ['tier' => 'B', 'name' => 'Humour'],
                ['tier' => 'B', 'name' => 'Intelligence'],
                ['tier' => 'B', 'name' => 'Fitness'],
                ['tier' => 'B', 'name' => 'Money'],
            ];
            $tierColors = [
                'S' => ['bg' => '#C8943E', 'text' => 'var(--bg-screen)'],
                'A' => ['bg' => '#E8B86A', 'text' => 'var(--bg-screen)'],
                'B' => ['bg' => '#8C7A5E', 'text' => 'var(--text-primary)'],
            ];
        @endphp

        @foreach($triggers as $trigger)
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                <span style="background:{{ $tierColors[$trigger['tier']]['bg'] }};color:{{ $tierColors[$trigger['tier']]['text'] }};font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;min-width:24px;text-align:center">{{ $trigger['tier'] }}</span>
                <span style="font-size:13px;color:var(--text-primary)">{{ $trigger['name'] }}</span>
            </div>
        @endforeach

        <div style="margin-bottom:2rem"></div>

        {{-- Section 4: How She Experiences Dating --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">HOW SHE EXPERIENCES DATING</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">She's heard "you're beautiful" from a thousand guys. It's the same conversation on repeat. Break the pattern.</p>

        <p style="font-size:13px;line-height:1.6;margin-bottom:2rem"><span style="color:var(--text-primary);font-weight:600">Compliment what she earned,</span> <span style="color:var(--text-secondary)">never what she was born with.</span></p>

        {{-- Section 5: The 10 Text Rules --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE 10 TEXT RULES</h2>

        @php
            $textRules = [
                'Statements over questions',
                'Drop the question mark',
                'Keep it short, 2 lines max',
                'Never reply instantly',
                'End convos first, at the peak',
                'Embed triggers subtly',
                'Create ambiguity',
                'Never profess feelings first',
                'No response? No ego. Fresh start.',
                "Check she's free before inviting",
            ];
        @endphp

        @foreach($textRules as $i => $rule)
            <div style="display:flex;gap:12px;margin-bottom:8px">
                <span style="color:var(--brand-gold);font-size:14px;font-weight:700;min-width:18px">{{ $i + 1 }}</span>
                <span style="font-size:13px;color:var(--text-secondary);line-height:1.6">{{ $rule }}</span>
            </div>
        @endforeach

        <div style="margin-bottom:2rem"></div>

        {{-- Section 6: Reframing --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">REFRAMING</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">Always choose the interpretation that moves things forward.</p>

        @php
            $reframingSteps = [
                ['step' => '1', 'title' => 'VALIDATE', 'desc' => 'Make her feel heard.'],
                ['step' => '2', 'title' => 'REDIRECT', 'desc' => 'Shift to a better frame.'],
                ['step' => '3', 'title' => 'ANCHOR', 'desc' => 'End with something she agrees with.'],
            ];
        @endphp

        @foreach($reframingSteps as $step)
            <div style="background:var(--bg-card);border:1px solid var(--border-card);border-radius:14px;padding:14px 16px;margin-bottom:10px">
                <div style="font-size:13px;font-weight:700;color:var(--text-primary);margin-bottom:4px">{{ $step['step'] }}. {{ $step['title'] }}</div>
                <div style="font-size:12px;color:var(--text-secondary)">{{ $step['desc'] }}</div>
            </div>
        @endforeach

        <div style="margin-bottom:2rem"></div>

        {{-- Section 7: Emergency Reset --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">EMERGENCY RESET</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">Ask yourself when it's slipping:</p>

        @php
            $resetQuestions = [
                'Am I chasing right now?',
                'Would I do this if I had 10 other options?',
                'Am I trying to impress or evaluate?',
                'How much effort am I showing?',
                'Am I being the yes-man?',
            ];
        @endphp

        @foreach($resetQuestions as $q)
            <div style="display:flex;gap:8px;margin-bottom:8px">
                <span style="color:var(--brand-gold);font-size:13px">&rarr;</span>
                <span style="font-size:13px;color:var(--text-secondary);line-height:1.6">{{ $q }}</span>
            </div>
        @endforeach

        <div style="margin-bottom:2rem"></div>

        {{-- Section 8: CTA Footer --}}
        <a href="{{ route('strat-chat') }}" style="display:block;text-align:center;background:var(--bg-card);border:1px solid var(--border-card);border-radius:14px;padding:16px;text-decoration:none;color:var(--brand-gold);font-size:14px;font-weight:700">
            Now open Strat Chat &rarr;
        </a>
    </div>
</div>
