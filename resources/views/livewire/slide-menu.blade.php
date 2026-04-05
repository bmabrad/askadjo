<div>
    {{-- Backdrop --}}
    @if($open)
        <div
            wire:click="close"
            style="position:fixed;inset:0;z-index:199;background:rgba(0,0,0,0.5)"
            x-data
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        ></div>
    @endif

    {{-- Panel --}}
    <div style="
        position:fixed;top:0;left:0;bottom:0;width:100%;max-width:420px;
        z-index:200;
        background:var(--bg-screen, var(--bg-primary));
        transform:{{ $open ? 'translateX(0)' : 'translateX(-100%)' }};
        transition:transform 250ms ease-out;
        display:flex;flex-direction:column;
        overflow:hidden;
    ">
        {{-- Menu Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border-card, var(--border))">
            <div style="display:flex;align-items:center;gap:10px">
                {{-- King Chess SVG (AskAdjo_King_LOGO.svg — uses currentColor) --}}
                <svg width="38" height="42" viewBox="0 0 124 120" fill="none" xmlns="http://www.w3.org/2000/svg" style="position:relative;top:-4px;color:#C8943E">
                    <path d="M54 44 L54 34 L58 38 L62 28 L66 38 L70 34 L70 44" fill="none" stroke="currentColor" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
                    <circle cx="62" cy="58" r="14" fill="none" stroke="currentColor" stroke-width="5.5"/>
                    <path d="M48 68 Q44 86 38 102 L86 102 Q80 86 76 68" fill="none" stroke="currentColor" stroke-width="5.5" stroke-linejoin="round"/>
                    <path d="M34 102 L90 102 Q94 102 94 106 L94 112 Q94 116 90 116 L34 116 Q30 116 30 112 L30 106 Q30 102 34 102 Z" fill="none" stroke="currentColor" stroke-width="5.5"/>
                </svg>
                <span style="font-size:26px;font-weight:800;letter-spacing:1.5px;transform:scaleY(0.85);display:inline-block;color:var(--text-primary)">AskAdjo</span>
            </div>
            <button wire:click="close" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:none;border:none;cursor:pointer;border-radius:8px;color:var(--close-color, #8C7A5E)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Menu Cards --}}
        <div style="flex:1;overflow-y:auto;padding:16px 16px 8px">
            @php
                $menuItems = [
                    ['route' => 'strat-chat', 'icon' => 'envelope', 'title' => 'Strat Chat', 'subtitle' => 'Drop Texts In Here & Chat Live.'],
                    ['route' => 'mindset', 'icon' => 'diamond', 'title' => 'The Mindset', 'subtitle' => 'A 3 Minute Overview Of The Playbook.'],
                    ['route' => 'playbook', 'icon' => 'trigram', 'title' => 'The Playbook', 'subtitle' => 'The Full Methodology.'],
                    ['route' => 'quick-ref', 'icon' => 'lightning', 'title' => 'Quick Reference', 'subtitle' => 'Swipeable Cheat Sheets. 5 Second Scan.'],
                ];
            @endphp

            @foreach($menuItems as $item)
                <a
                    href="{{ route($item['route']) }}"
                    wire:click="close"
                    style="display:flex;align-items:center;gap:11px;padding:18px 20px;margin-bottom:14px;border-radius:14px;text-decoration:none;border:1px solid var(--border-card, var(--border));background:var(--bg-card, var(--bg-secondary));transition:background 0.15s"
                >
                    {{-- Icon Container --}}
                    <div style="width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:var(--bg-icon, var(--bg-input));border:1px solid var(--border-icon, var(--border));flex-shrink:0">
                        @if($item['icon'] === 'envelope')
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--icon-color, #E8B86A)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22,4 12,13 2,4"/></svg>
                        @elseif($item['icon'] === 'diamond')
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--icon-color, #E8B86A)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 12l10 10 10-10L12 2z"/></svg>
                        @elseif($item['icon'] === 'trigram')
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--icon-color, #E8B86A)" stroke-width="2.5" stroke-linecap="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
                        @elseif($item['icon'] === 'lightning')
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--icon-color, #E8B86A)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        @endif
                    </div>
                    {{-- Text --}}
                    <div style="flex:1;min-width:0">
                        <div style="font-size:16px;font-weight:700;color:var(--text-primary)">{{ $item['title'] }}</div>
                        <div style="font-size:11px;color:var(--text-secondary);margin-top:2px">{{ $item['subtitle'] }}</div>
                    </div>
                    {{-- Chevron --}}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--chevron-color, #8C7A5E)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            @endforeach

            {{-- V2 Divider --}}
            <div style="display:flex;align-items:center;gap:10px;margin:6px 0 14px">
                <div style="flex:1;height:1px;background:var(--border-card, var(--border))"></div>
                <span style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;white-space:nowrap">Coming in V2</span>
                <div style="flex:1;height:1px;background:var(--border-card, var(--border))"></div>
            </div>

            {{-- V2 Cards (display-only, reduced opacity) --}}
            @php
                $v2Items = [
                    ['icon' => 'speech', 'title' => 'Example Messages', 'subtitle' => '44 Real Conversations By Situation.'],
                    ['icon' => 'camera', 'title' => 'Profile Photos', 'subtitle' => 'The 6 Photos Your Profile Needs.'],
                ];
            @endphp

            @foreach($v2Items as $item)
                <div style="display:flex;align-items:center;gap:11px;padding:18px 20px;margin-bottom:14px;border-radius:14px;border:1px solid var(--border-card, var(--border));background:var(--bg-card, var(--bg-secondary));opacity:0.5">
                    {{-- Icon Container --}}
                    <div style="width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:var(--bg-icon, var(--bg-input));border:1px solid var(--border-icon, var(--border));flex-shrink:0">
                        @if($item['icon'] === 'speech')
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--icon-color, #E8B86A)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        @elseif($item['icon'] === 'camera')
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--icon-color, #E8B86A)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        @endif
                    </div>
                    {{-- Text --}}
                    <div style="flex:1;min-width:0">
                        <div style="font-size:16px;font-weight:700;color:var(--text-primary)">{{ $item['title'] }}</div>
                        <div style="font-size:11px;color:var(--text-secondary);margin-top:2px">{{ $item['subtitle'] }}</div>
                    </div>
                    {{-- Chevron --}}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--chevron-color, #8C7A5E)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><polyline points="9 18 15 12 9 6"/></svg>
                </div>
            @endforeach
        </div>

        {{-- User Bar --}}
        <div style="padding:16px 20px;border-top:1px solid var(--border-card, var(--border));display:flex;align-items:center;justify-content:space-between">
            <div style="display:flex;align-items:center;gap:10px">
                {{-- Avatar --}}
                <div style="width:36px;height:36px;border-radius:50%;background:var(--bg-avatar, var(--bg-icon));display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--text-muted)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <span style="font-size:14px;font-weight:600;color:var(--text-primary)">{{ auth()->user()->name }}</span>
                    <span style="display:inline-block;margin-left:8px;font-size:11px;font-weight:700;color:var(--brand-gold, #C8943E);background:rgba(200,148,62,0.15);padding:2px 8px;border-radius:4px">FREE</span>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                {{-- Theme Toggle (Sun icon) --}}
                <button wire:click="toggleTheme" title="Toggle theme" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:none;border:none;cursor:pointer;border-radius:8px;color:var(--icon-color, #E8B86A)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                </button>
                {{-- Settings Gear --}}
                <a href="{{ route('settings') }}" wire:click="close" title="Settings" style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;background:none;border:none;cursor:pointer;border-radius:8px;color:var(--icon-color, #E8B86A);text-decoration:none">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
