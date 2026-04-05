<div>
    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:center;gap:0.75rem">
            <a href="javascript:history.back()" style="color:var(--text-secondary);text-decoration:none;font-size:1.25rem">&larr;</a>
            <h1 style="font-size:1.25rem;font-weight:700;margin:0;color:var(--text-primary)">The Playbook</h1>
        </div>
        <a href="{{ route('strat-chat') }}" style="color:var(--close-color, #8C7A5E);text-decoration:none;font-size:1.25rem">&times;</a>
    </div>

    {{-- Scrollable Content --}}
    <div style="padding-bottom:3rem">

        {{-- Section 1: The One Rule --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE ONE RULE</h2>

        <div style="background:var(--bg-card);border-left:3px solid var(--brand-gold);border-radius:0 10px 10px 0;padding:14px 16px;margin-bottom:1.25rem">
            <p style="color:var(--brand-gold-light);font-style:italic;font-size:13px;line-height:1.6;margin:0">"The goal is not for her to wonder if you like her. It's for her to wonder why you don't like her more."</p>
        </div>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1.25rem">Every piece of advice this app gives comes back to that line. When you're chasing, your flaws get magnified and her value inflates in your eyes. When she's chasing, your flaws disappear and you see her clearly. Same two people. Completely different dynamic depending on who's pursuing.</p>

        {{-- Comparison Block --}}
        <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:1.25rem">
            <div style="flex:1;min-width:220px;background:var(--bg-card);border:1px solid var(--border-card);border-radius:14px;padding:16px">
                <div style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:8px">When you're chasing:</div>
                @foreach(['Your flaws are magnified', 'Her flaws are invisible to you', 'Your value drops', 'She thinks: "Do I even want him?"'] as $item)
                    <div style="display:flex;gap:8px;margin-bottom:6px">
                        <span style="color:var(--brand-gold);font-size:13px">&rarr;</span>
                        <span style="font-size:13px;color:var(--text-secondary);line-height:1.5">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
            <div style="flex:1;min-width:220px;background:var(--bg-card);border:1px solid var(--border-card);border-radius:14px;padding:16px">
                <div style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:8px">When she's chasing:</div>
                @foreach(['Your flaws disappear', 'Her flaws are visible to you', 'Your value rises', 'She thinks: "Why am I so into him?"'] as $item)
                    <div style="display:flex;gap:8px;margin-bottom:6px">
                        <span style="color:var(--brand-gold);font-size:13px">&rarr;</span>
                        <span style="font-size:13px;color:var(--text-secondary);line-height:1.5">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:2rem">Every suggestion the app makes is designed to keep you on the right side of that dynamic.</p>

        {{-- Section 2: The 4 Frames --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE 4 FRAMES</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1.25rem">These fix 90% of mistakes before they happen. Adopt these frames and the right behaviours follow naturally.</p>

        {{-- Frame 1 --}}
        <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem">Frame 1: Be the evaluator</h3>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">Most guys think "how do I get her to like me?" That's the applicant frame, you're auditioning for her approval. Flip it. Your question should be: "Is she interesting enough for me?" Think of it like someone pitching you an investment. You don't chase it, you evaluate it. Is it worth your time? Does it meet your standards?</p>
        <div style="background:var(--bg-card);border-left:3px solid var(--brand-gold);border-radius:0 10px 10px 0;padding:14px 16px;margin-bottom:1.5rem">
            <p style="color:var(--brand-gold-light);font-style:italic;font-size:13px;line-height:1.6;margin:0">"Stop asking 'what should I say to make her like me' and start asking 'what has she done to earn my interest.'"</p>
        </div>

        {{-- Frame 2 --}}
        <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem">Frame 2: Challenging beats nice</h3>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">A conversation where you just nod and agree is the most boring interaction possible. When everyone in her life is a yes-person, she craves someone who pushes back. Think about a manager interviewing someone. They're not agreeing with everything, they're challenging, asking tough questions, evaluating. That's the energy you want.</p>
        <div style="background:var(--bg-card);border-left:3px solid var(--brand-gold);border-radius:0 10px 10px 0;padding:14px 16px;margin-bottom:1.5rem">
            <p style="color:var(--brand-gold-light);font-style:italic;font-size:13px;line-height:1.6;margin:0">"If you genuinely disagree, say so. She'll respect you more, not less."</p>
        </div>

        {{-- Frame 3 --}}
        <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem">Frame 3: Low visible effort</h3>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">In business, effort gets rewarded. In attraction, visible effort gets punished. The more you show how hard you're trying, the higher you're placing her value above yours. Think of a comedian. They've rehearsed 300 times, but the audience only sees the effortless delivery. Same principle.</p>
        <div style="background:var(--bg-card);border-left:3px solid var(--brand-gold);border-radius:0 10px 10px 0;padding:14px 16px;margin-bottom:1.5rem">
            <p style="color:var(--brand-gold-light);font-style:italic;font-size:13px;line-height:1.6;margin:0">"If you wouldn't tell your mate how hard you tried, don't tell her."</p>
        </div>

        {{-- Frame 4 --}}
        <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem">Frame 4: No limiting beliefs</h3>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">Height, race, income, looks, none of these are the variable. Your approach is. In a psychology study, participants had a fake scar applied to their face before an interview. The scar was secretly removed before they went in. Nine out of ten reported the interviewer kept staring at the scar, which wasn't there.</p>
        <div style="background:var(--bg-card);border-left:3px solid var(--brand-gold);border-radius:0 10px 10px 0;padding:14px 16px;margin-bottom:2rem">
            <p style="color:var(--brand-gold-light);font-style:italic;font-size:13px;line-height:1.6;margin:0">"The belief changes the behaviour. The behaviour produces the result. Not the attribute."</p>
        </div>

        {{-- Section 3: The 10 Attraction Triggers --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE 10 ATTRACTION TRIGGERS</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1.25rem">Attraction isn't one thing. It's a system with 10 inputs. You don't need all of them, you need your top 3 to be strong.</p>

        @php
            $triggers = [
                ['tier' => 'S', 'name' => 'Preselection', 'desc' => 'Other women are visibly interested in you. The most powerful trigger.'],
                ['tier' => 'S', 'name' => 'Being a Challenge', 'desc' => "You don't give your attention away for free. She has to earn it."],
                ['tier' => 'A', 'name' => 'Confidence', 'desc' => 'Not giddy, not eager, not hedging every message with LOL and emojis.'],
                ['tier' => 'A', 'name' => 'Status', 'desc' => "People respect you. The staff know your name. You're known."],
                ['tier' => 'A', 'name' => 'Social Intuition', 'desc' => "You read the room. You know what lands and what doesn't."],
                ['tier' => 'A', 'name' => 'Leadership', 'desc' => 'You run things. A business, a team, a project. People defer to you.'],
                ['tier' => 'B', 'name' => 'Humour', 'desc' => 'Makes everything else more palatable. Bragging + humour = likeable.'],
                ['tier' => 'B', 'name' => 'Intelligence', 'desc' => 'You appear thoughtful and articulate. The bar is low.'],
                ['tier' => 'B', 'name' => 'Fitness', 'desc' => 'Baseline requirement. Activity photos, not gym selfies.'],
                ['tier' => 'B', 'name' => 'Money', 'desc' => 'Helpful if used right. Devastating if used wrong. Never lead with it.'],
            ];
            $tierColors = [
                'S' => ['bg' => '#C8943E', 'text' => 'var(--bg-screen)'],
                'A' => ['bg' => '#E8B86A', 'text' => 'var(--bg-screen)'],
                'B' => ['bg' => '#8C7A5E', 'text' => 'var(--text-primary)'],
            ];
        @endphp

        @foreach($triggers as $trigger)
            <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px">
                <span style="background:{{ $tierColors[$trigger['tier']]['bg'] }};color:{{ $tierColors[$trigger['tier']]['text'] }};font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;min-width:24px;text-align:center;margin-top:2px">{{ $trigger['tier'] }}</span>
                <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text-primary)">{{ $trigger['name'] }}</div>
                    <div style="font-size:12px;color:var(--text-secondary);line-height:1.5">{{ $trigger['desc'] }}</div>
                </div>
            </div>
        @endforeach

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-top:1rem;margin-bottom:2rem">The app weaves these into the messages it suggests. When it mentions the gym, it's embedding fitness. When it suggests ending the conversation early, it's creating scarcity. Now you know why.</p>

        {{-- Section 4: How She Experiences Dating --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">HOW SHE EXPERIENCES DATING</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">If you're an attractive woman, your dating life looks like this: since age 14, guys have been approaching you, complimenting your looks, buying you drinks, asking for your number. You've had the same conversation with thousands of men. The accountant says "you're beautiful." The dentist says "you have pretty eyes." It's the same script on repeat.</p>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1.25rem">To stand out, break the pattern. The app never suggests a physical compliment as an opener. Instead: curiosity, challenge, and specificity.</p>

        <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem">The compliment rule</h3>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">Compliment what she earned, never what she was born with. She didn't work for her blue eyes. She's had them for 24 years and everyone's commented on them. But if she became a nurse because her grandmother was sick, that's something she invested in.</p>

        <div style="background:var(--bg-card);border-left:3px solid var(--brand-gold);border-radius:0 10px 10px 0;padding:14px 16px;margin-bottom:2rem">
            <p style="color:var(--brand-gold-light);font-style:italic;font-size:13px;line-height:1.6;margin:0">"Fewer compliments, not more. Make her tell you something real about herself first. Then, and only then, give a genuine compliment on something that matters."</p>
        </div>

        {{-- Section 5: The Text Rules --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE TEXT RULES</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1.25rem">The principles behind every message the app suggests. You don't need to memorise them, the app applies them automatically.</p>

        @php
            $textRules = [
                ['title' => 'Statements over questions.', 'body' => '"Heading to that wine bar later if you want to come" not "Do you want to come to the wine bar with me?"'],
                ['title' => 'Drop the question mark.', 'body' => '"What are you doing tonight" reads differently than "What are you doing tonight?" The question mark adds pressure.'],
                ['title' => 'Keep it short.', 'body' => 'If your text is longer than two lines, cut it in half.'],
                ['title' => 'Never reply instantly.', 'body' => 'Minimum 5 minutes. Vary your times, sometimes 5 minutes, sometimes a couple of hours.'],
                ['title' => 'End conversations first.', 'body' => 'And end them at the high point, not when things go quiet.'],
                ['title' => 'Embed triggers subtly.', 'body' => '"Headed to tennis, message you later" is a fitness trigger + having a life. Not "I play 5 sports."'],
                ['title' => 'Create ambiguity.', 'body' => '"Out at dinner", never specify with whom. Let her wonder.'],
                ['title' => 'Never profess feelings first.', 'body' => 'Let her show interest. Then reciprocate.'],
                ['title' => 'No response? No ego.', 'body' => 'Start a fresh thread later. Never say "did you see my message?"'],
                ['title' => "Check she's free before inviting.", 'body' => '"What does your weekend look like", she reveals the slot, you fill it.'],
            ];
        @endphp

        @foreach($textRules as $i => $rule)
            <div style="display:flex;gap:12px;margin-bottom:1rem">
                <span style="color:var(--brand-gold);font-size:14px;font-weight:700;min-width:18px">{{ $i + 1 }}</span>
                <p style="font-size:13px;line-height:1.6;margin:0"><span style="color:var(--text-primary);font-weight:600">{{ $rule['title'] }}</span> <span style="color:var(--text-secondary)">{{ $rule['body'] }}</span></p>
            </div>
        @endforeach

        <div style="margin-bottom:2rem"></div>

        {{-- Section 6: Reframing --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">THE MOST IMPORTANT SKILL: REFRAMING</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1.25rem">When she says something that could go multiple ways, always choose the interpretation that moves things forward.</p>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:0.5rem">She says: "I haven't slept with many guys."</p>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">Three possible interpretations:</p>

        <div style="display:flex;gap:12px;margin-bottom:6px">
            <span style="color:var(--brand-gold);font-size:14px;font-weight:700;min-width:18px">1</span>
            <span style="font-size:13px;color:var(--text-secondary);line-height:1.6">She's conservative &rarr; kills the thread</span>
        </div>
        <div style="display:flex;gap:12px;margin-bottom:6px">
            <span style="color:var(--brand-gold);font-size:14px;font-weight:700;min-width:18px">2</span>
            <span style="font-size:13px;color:var(--text-secondary);line-height:1.6">She's picky &rarr; neutral</span>
        </div>
        <div style="display:flex;gap:12px;margin-bottom:1rem">
            <span style="color:var(--brand-gold);font-size:14px;font-weight:700;min-width:18px">3</span>
            <span style="font-size:13px;color:var(--text-secondary);line-height:1.6">She hasn't found skilled enough guys &rarr; creates a gap you can fill</span>
        </div>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">The right response picks #3: "I totally get it. At your age, it's hard to find skilled and experienced guys."</p>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">Her reply: "Usually go after older for that exact reason."</p>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1.5rem">He positioned himself as the rare exception. If he'd chosen interpretation #1, the thread would have died.</p>

        <h3 style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem">The formula</h3>
        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">When she sets a frame you don't want, never argue head-on. Instead:</p>

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

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-top:1rem;margin-bottom:2rem">The app does this for you in its suggested replies. Now you understand the mechanics behind it.</p>

        {{-- Section 7: You're Ready --}}
        <h2 style="color:var(--brand-gold);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:1rem">YOU'RE READY</h2>

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem">You now understand:</p>

        @php
            $readyItems = [
                'The one rule that governs everything',
                'The four frames that prevent 90% of mistakes',
                'The 10 triggers that create attraction',
                'How she experiences dating',
                'The text rules the app applies',
                'How to reframe anything she throws at you',
            ];
        @endphp

        @foreach($readyItems as $item)
            <div style="display:flex;gap:8px;margin-bottom:8px">
                <span style="color:var(--brand-gold);font-size:13px">&rarr;</span>
                <span style="font-size:13px;color:var(--text-secondary);line-height:1.6">{{ $item }}</span>
            </div>
        @endforeach

        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin-top:1rem;margin-bottom:1.5rem">You don't need to memorise any of this. The app handles the execution. But now when it suggests something bold, you'll understand why, and you'll send it with confidence.</p>

        {{-- CTA --}}
        <a href="{{ route('strat-chat') }}" style="display:block;text-align:center;background:var(--bg-card);border:1px solid var(--border-card);border-radius:14px;padding:16px;text-decoration:none;color:var(--brand-gold);font-size:14px;font-weight:700">
            Open Strat Chat, paste a conversation, and let's get to work. &rarr;
        </a>
    </div>
</div>
