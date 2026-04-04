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
        .app-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <header class="app-header">
        <a href="{{ route('dashboard') }}" class="logo" style="text-decoration:none;color:var(--text-primary)">AskAdjo</a>
        <div class="header-actions">
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
</body>
</html>
