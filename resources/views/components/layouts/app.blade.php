<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AskAdjo') }}</title>
    <script>
        (function(){
            var t;try{t=localStorage.getItem('askadjo-theme')}catch(e){}
            if(t!=='light')t='dark';
            document.documentElement.setAttribute('data-theme',t);
        })();
    </script>
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --transition-speed: 0.25s;
            --radius: 10px;
            --radius-sm: 6px;
            --brand-gold: #C8943E;
            --brand-gold-light: #E8B86A;
        }
        [data-theme="dark"] {
            --bg-primary: #131314;
            --bg-secondary: #1a1a1c;
            --bg-card: #1e1e20;
            --bg-input: #252525;
            --bg-hover: #2A2A2A;
            --bg-nav: rgba(14, 14, 24, 0.92);
            --text-primary: #F5F0E8;
            --text-secondary: #9A8A72;
            --text-muted: #8C7A5E;
            --border: #2a2a2c;
            --border-hover: #3a3a3c;
            --border-focus: #C8943E;
            --btn-primary-bg: #C8943E;
            --btn-primary-text: #131314;
            --btn-secondary-bg: transparent;
            --btn-secondary-border: #3a3a3c;
            --btn-secondary-text: #F5F0E8;
            --btn-danger-bg: #555555;
            --btn-danger-text: #E5E5E5;
            --success: #C8943E;
            --error: #FF6B6B;
            --accent: #C8943E;
            --recommended-border: #C8943E;
            --pill-bg: #252525;
            --pill-border: #444444;
            --pill-text: #CCCCCC;
            --coach-bubble: #1A3A5C;
            --coach-bubble-border: #1E4A6E;
            /* Menu-specific tokens */
            --bg-screen: #0E0E18;
            --bg-icon: #24222E;
            --bg-avatar: #24222E;
            --border-card: #2A2834;
            --border-icon: #3A3844;
            --icon-color: #E8B86A;
            --chevron-color: #8C7A5E;
            --close-color: #8C7A5E;
        }
        [data-theme="light"] {
            --bg-primary: #fafaf9;
            --bg-secondary: #f0efed;
            --bg-card: #ffffff;
            --bg-input: #f5f5f4;
            --bg-hover: #eaeae8;
            --bg-nav: rgba(245, 240, 232, 0.92);
            --text-primary: #1A1A2E;
            --text-secondary: #8C7A5E;
            --text-muted: #8C7A5E;
            --text-dark: #3A3A4E;
            --border: #e5e4e2;
            --border-hover: #d0cfcc;
            --border-focus: #C8943E;
            --btn-primary-bg: #C8943E;
            --btn-primary-text: #ffffff;
            --btn-secondary-bg: transparent;
            --btn-secondary-border: #d0cfcc;
            --btn-secondary-text: #1A1A2E;
            --btn-danger-bg: #e5e4e2;
            --btn-danger-text: #1a1a1a;
            --success: #C8943E;
            --error: #FF6B6B;
            --accent: #C8943E;
            --recommended-border: #C8943E;
            --pill-bg: #f0efed;
            --pill-border: #d0cfcc;
            --pill-text: #444444;
            --coach-bubble: #dbeafe;
            --coach-bubble-border: #bfdbfe;
            /* Menu-specific tokens */
            --bg-screen: #F5F0E8;
            --bg-icon: #F5F0E8;
            --bg-avatar: #E8DCC8;
            --border-card: #E8DCC8;
            --border-icon: #E8DCC8;
            --icon-color: #C8943E;
            --chevron-color: #E8B86A;
            --close-color: #E8B86A;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            font-size: 16px;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        /* ── Phone Frame ── */
        .phone-frame {
            max-width: 430px;
            margin: 0 auto;
            min-height: 100vh;
            background: var(--bg-primary);
            border-left: 1px solid var(--border);
            border-right: 1px solid var(--border);
            position: relative;
        }
        @media (max-width: 430px) {
            .phone-frame { border-left: none; border-right: none; }
        }

        /* ── Nav ── */
        .nav { position: sticky; top: 0; z-index: 100; background: var(--bg-nav); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); transition: background-color var(--transition-speed), border-color var(--transition-speed); }
        .nav-inner { padding: 0 24px; height: 60px; display: flex; align-items: center; }
        .nav-logo { display: flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; padding: 4px 0; }
        .nav-logo-text { font-size: 26px; font-weight: 800; letter-spacing: 1.5px; transform: scaleY(0.85); display: inline-block; color: var(--text-primary); }

        .app-content {
            padding: 1rem;
        }
    </style>
</head>
<body
    x-data
    @theme-changed.window="
        document.documentElement.setAttribute('data-theme', $event.detail.theme);
        try { localStorage.setItem('askadjo-theme', $event.detail.theme); } catch(e) {}
    "
>
    <div class="phone-frame">
        <!-- Nav -->
        <nav class="nav">
            <div class="nav-inner">
                <div class="nav-logo" x-data @click="$dispatch('toggle-slide-menu')">
                    {{-- King Chess SVG (AskAdjo_King_LOGO.svg — uses currentColor) --}}
                    <svg width="38" height="42" viewBox="0 0 124 120" fill="none" xmlns="http://www.w3.org/2000/svg" style="position:relative;top:-4px;color:#C8943E">
                        <path d="M54 44 L54 34 L58 38 L62 28 L66 38 L70 34 L70 44" fill="none" stroke="currentColor" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
                        <circle cx="62" cy="58" r="14" fill="none" stroke="currentColor" stroke-width="5.5"/>
                        <path d="M48 68 Q44 86 38 102 L86 102 Q80 86 76 68" fill="none" stroke="currentColor" stroke-width="5.5" stroke-linejoin="round"/>
                        <path d="M34 102 L90 102 Q94 102 94 106 L94 112 Q94 116 90 116 L34 116 Q30 116 30 112 L30 106 Q30 102 34 102 Z" fill="none" stroke="currentColor" stroke-width="5.5"/>
                    </svg>
                    <span class="nav-logo-text">AskAdjo.ai</span>
                </div>
            </div>
        </nav>

        {{-- Slide Menu --}}
        <livewire:slide-menu />

        <main class="app-content">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
