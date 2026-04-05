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
            --user-bubble-text: #0E0E18;
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
            --user-bubble-text: #FFFFFF;
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
        {{-- Slide Menu --}}
        <livewire:slide-menu />

        <main class="app-content">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
