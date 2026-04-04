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
            if(!t)t='dark';
            var r=t==='system'?(window.matchMedia('(prefers-color-scheme:dark)').matches?'dark':'light'):t;
            document.documentElement.setAttribute('data-theme',r);
        })();
    </script>
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --transition-speed: 0.25s;
            --accent: #d97757;
            --error: #FF6B6B;
        }
        [data-theme="dark"] {
            --bg-primary: #131314;
            --bg-secondary: #1a1a1c;
            --bg-card: #1e1e20;
            --bg-input: #252525;
            --bg-hover: #2A2A2A;
            --bg-nav: rgba(19, 19, 20, 0.85);
            --text-primary: #ececec;
            --text-secondary: #a0a0a0;
            --text-muted: #666666;
            --border: #2a2a2c;
            --border-hover: #3a3a3c;
            --border-focus: #777777;
            --btn-primary-bg: #ececec;
            --btn-primary-text: #131314;
            --btn-secondary-bg: transparent;
            --btn-secondary-border: #3a3a3c;
            --btn-secondary-text: #ececec;
            --btn-danger-bg: #555555;
            --btn-danger-text: #E5E5E5;
            --success: #CCCCCC;
            --recommended-border: #777777;
            --pill-bg: #252525;
            --pill-border: #444444;
            --pill-text: #CCCCCC;
            --coach-bubble: #1A3A5C;
            --coach-bubble-border: #1E4A6E;
        }
        [data-theme="light"] {
            --bg-primary: #fafaf9;
            --bg-secondary: #f0efed;
            --bg-card: #ffffff;
            --bg-input: #f5f5f4;
            --bg-hover: #eaeae8;
            --bg-nav: rgba(250, 250, 249, 0.85);
            --text-primary: #1a1a1a;
            --text-secondary: #6b6b6b;
            --text-muted: #999999;
            --border: #e5e4e2;
            --border-hover: #d0cfcc;
            --border-focus: #aaaaaa;
            --btn-primary-bg: #1a1a1a;
            --btn-primary-text: #fafaf9;
            --btn-secondary-bg: transparent;
            --btn-secondary-border: #d0cfcc;
            --btn-secondary-text: #1a1a1a;
            --btn-danger-bg: #e5e4e2;
            --btn-danger-text: #1a1a1a;
            --success: #444444;
            --recommended-border: #aaaaaa;
            --pill-bg: #f0efed;
            --pill-border: #d0cfcc;
            --pill-text: #444444;
            --coach-bubble: #dbeafe;
            --coach-bubble-border: #bfdbfe;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            font-size: 16px;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }
        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            background: var(--bg-nav);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            min-height: 56px;
            transition: background-color var(--transition-speed), border-color var(--transition-speed);
        }
        .app-header .logo {
            font-size: 1.125rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: visible;
            color: var(--text-primary);
        }
        .app-header .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .app-header .header-actions a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
        }
        .app-header .header-actions a:hover {
            color: var(--text-primary);
        }
        .app-header .header-actions button {
            transition: color 0.15s;
        }
        .app-header .header-actions button:hover {
            color: var(--text-primary);
        }
        .app-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Theme switcher */
        .theme-switcher { display: inline-flex; align-items: center; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 20px; padding: 3px; gap: 2px; }
        .theme-btn { display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border: none; border-radius: 50%; background: transparent; color: var(--text-muted); cursor: pointer; transition: color 0.15s, background-color 0.15s; }
        .theme-btn:hover { color: var(--text-secondary); }
        .theme-btn.active { background: var(--bg-card); color: var(--text-primary); box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .theme-btn svg { width: 14px; height: 14px; }
    </style>
</head>
<body>
    <header class="app-header">
        <a href="{{ route('dashboard') }}" class="logo" style="text-decoration:none;color:var(--text-primary)">AskAdjo</a>
        <div class="header-actions">
            <div class="theme-switcher">
                <button class="theme-btn" data-theme-choice="light" title="Light mode">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                </button>
                <button class="theme-btn" data-theme-choice="system" title="System preference">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </button>
                <button class="theme-btn" data-theme-choice="dark" title="Dark mode">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>
            </div>
            <a href="{{ route('settings') }}">Settings</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" style="background:none;border:none;color:var(--text-secondary);cursor:pointer;font-size:0.875rem">Log out</button>
            </form>
        </div>
    </header>
    <main class="app-content">
        {{ $slot }}
    </main>
    @livewireScripts
    <script>
        // ── Theme ──
        function getSystemTheme() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        function applyTheme(choice) {
            var resolved = choice === 'system' ? getSystemTheme() : choice;
            document.documentElement.setAttribute('data-theme', resolved);
            document.querySelectorAll('.theme-btn').forEach(function(btn) {
                btn.classList.toggle('active', btn.getAttribute('data-theme-choice') === choice);
            });
            try { localStorage.setItem('askadjo-theme', choice); } catch(e) {}
        }
        var saved = null;
        try { saved = localStorage.getItem('askadjo-theme'); } catch(e) {}
        applyTheme(saved || 'dark');
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
            var current = null;
            try { current = localStorage.getItem('askadjo-theme'); } catch(e) {}
            if (current === 'system') applyTheme('system');
        });
        document.querySelectorAll('.theme-btn').forEach(function(btn) {
            btn.addEventListener('click', function() { applyTheme(this.getAttribute('data-theme-choice')); });
        });
    </script>
</body>
</html>
