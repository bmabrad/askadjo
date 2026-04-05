<div style="width:100%;max-width:420px">

    {{-- Logo Lockup --}}
    <div style="text-align:center;margin-bottom:2rem">
        <div style="display:inline-flex;align-items:center;gap:10px">
            <svg width="38" height="42" viewBox="0 0 124 120" fill="none" xmlns="http://www.w3.org/2000/svg" style="position:relative;top:-4px;color:#C8943E">
                <path d="M54 44 L54 34 L58 38 L62 28 L66 38 L70 34 L70 44" fill="none" stroke="currentColor" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
                <circle cx="62" cy="58" r="14" fill="none" stroke="currentColor" stroke-width="5.5"/>
                <path d="M48 68 Q44 86 38 102 L86 102 Q80 86 76 68" fill="none" stroke="currentColor" stroke-width="5.5" stroke-linejoin="round"/>
                <path d="M34 102 L90 102 Q94 102 94 106 L94 112 Q94 116 90 116 L34 116 Q30 116 30 112 L30 106 Q30 102 34 102 Z" fill="none" stroke="currentColor" stroke-width="5.5"/>
            </svg>
            <span style="font-size:26px;font-weight:800;letter-spacing:1.5px;transform:scaleY(0.85);display:inline-block;color:var(--text-primary)">AskAdjo</span>
        </div>
    </div>

    {{-- How It Works Card --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-card);border-radius:16px;padding:24px 20px">

        <h2 style="font-size:16px;font-weight:700;color:var(--text-primary);margin-bottom:20px;text-align:center">Here's How It Works</h2>

        @php
            $steps = [
                ['title' => 'Drop Your Conversation In', 'desc' => 'Screenshot or paste the text from any dating app, DM, or message thread.'],
                ['title' => 'Get Strategic Feedback', 'desc' => 'Get a read on the situation, what principles apply, and 2-3 reply options with the reasoning behind each one.'],
                ['title' => 'Chat, Copy and Send', 'desc' => 'Go back and forth with me on options and strategy until we land on the right text. Then copy and send.'],
            ];
        @endphp

        @foreach($steps as $i => $step)
            <div style="display:flex;gap:14px;{{ !$loop->last ? 'margin-bottom:20px' : '' }}">
                <span style="font-size:16px;font-weight:800;color:var(--brand-gold);min-width:20px">{{ $i + 1 }}</span>
                <div>
                    <div style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:4px">{{ $step['title'] }}</div>
                    <div style="font-size:12px;color:var(--text-secondary);line-height:1.5">{{ $step['desc'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- CTA Button --}}
    <button
        wire:click="complete"
        style="display:block;width:100%;margin-top:24px;padding:16px;font-size:16px;font-weight:800;background:var(--brand-gold);color:var(--bg-screen);border:none;border-radius:12px;cursor:pointer"
    >
        Let's Go
    </button>

    {{-- Tagline --}}
    <p style="text-align:center;margin-top:28px;font-size:13px;font-style:italic;color:var(--text-muted);font-family:Georgia,'Times New Roman',serif;line-height:1.6">
        "The goal is not for her to wonder if you like her. It's for her to wonder why you don't like her more."
    </p>
</div>
