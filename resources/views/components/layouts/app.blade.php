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
            --radius: 10px;
            --radius-sm: 6px;
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

        /* ── Nav ── */
        .nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: var(--bg-nav); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); transition: background-color var(--transition-speed), border-color var(--transition-speed); }
        .nav-inner { max-width: 1080px; margin: 0 auto; padding: 0 24px; height: 60px; display: flex; align-items: center; justify-content: space-between; }
        .nav-left { position: relative; }
        .nav-logo { display: flex; align-items: center; gap: 8px; font-size: 20px; font-weight: 800; letter-spacing: -0.3px; cursor: pointer; user-select: none; padding: 4px 0; color: var(--text-primary); }
        .nav-logo-chevron { display: inline-flex; align-items: center; transition: transform 0.2s; }
        .nav-logo-chevron svg { width: 14px; height: 14px; }
        .nav-logo.open .nav-logo-chevron { transform: rotate(180deg); }

        /* Desktop dropdown */
        .logo-dropdown { position: absolute; top: calc(100% + 8px); left: 0; min-width: 160px; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 8px 24px rgba(0,0,0,0.2); opacity: 0; visibility: hidden; transform: translateY(-4px); transition: opacity 0.2s, visibility 0.2s, transform 0.2s, background-color var(--transition-speed), border-color var(--transition-speed); padding: 4px; z-index: 110; }
        .logo-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .logo-dropdown a, .logo-dropdown button { display: block; width: 100%; text-align: left; padding: 7px 12px; font-size: 13px; font-weight: 500; color: var(--text-secondary); border-radius: var(--radius-sm); transition: color 0.15s, background-color 0.15s; background: none; border: none; cursor: pointer; font-family: inherit; }
        .logo-dropdown a:hover, .logo-dropdown button:hover { color: var(--text-primary); background: var(--bg-secondary); }
        .logo-dropdown-divider { height: 1px; background: var(--border); margin: 4px 0; }

        .nav-right { display: flex; align-items: center; gap: 12px; }

        /* Theme switcher */
        .theme-switcher { display: inline-flex; align-items: center; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 20px; padding: 3px; gap: 2px; }
        .theme-btn { display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border: none; border-radius: 50%; background: transparent; color: var(--text-muted); cursor: pointer; transition: color 0.15s, background-color 0.15s; }
        .theme-btn:hover { color: var(--text-secondary); }
        .theme-btn.active { background: var(--bg-card); color: var(--text-primary); box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .theme-btn svg { width: 14px; height: 14px; }

        /* ── Mobile backdrop ── */
        .mobile-backdrop { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0); z-index: 98; pointer-events: none; transition: background 0.3s ease; }
        .mobile-backdrop.open { background: rgba(0,0,0,0.5); pointer-events: auto; }

        /* ── Mobile drawer ── */
        .mobile-drawer { position: fixed; top: 0; left: 0; bottom: 0; width: 95%; max-width: 400px; background: var(--bg-primary); z-index: 101; padding: 0; overflow-y: auto; transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), background-color var(--transition-speed); box-shadow: 4px 0 24px rgba(0,0,0,0.3); }
        .mobile-drawer.open { transform: translateX(0); }
        .mobile-drawer-header { display: flex; align-items: center; justify-content: space-between; padding: 0 24px; height: 60px; border-bottom: 1px solid var(--border); }
        .mobile-drawer-logo { font-size: 20px; font-weight: 800; letter-spacing: -0.3px; }
        .mobile-drawer-close { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: none; border: none; color: var(--text-secondary); cursor: pointer; border-radius: var(--radius-sm); transition: color 0.15s, background-color 0.15s; }
        .mobile-drawer-close:hover { color: var(--text-primary); background: var(--bg-secondary); }
        .mobile-drawer-close svg { width: 20px; height: 20px; }
        .mobile-drawer-body { padding: 12px 20px 28px; }
        .mobile-drawer-links { list-style: none; display: flex; flex-direction: column; gap: 2px; margin-bottom: 16px; }
        .mobile-drawer-links a, .mobile-drawer-links button { display: block; width: 100%; text-align: left; padding: 10px 12px; font-size: 15px; font-weight: 500; color: var(--text-secondary); border-radius: var(--radius-sm); transition: color 0.15s, background-color 0.15s; background: none; border: none; cursor: pointer; font-family: inherit; text-decoration: none; }
        .mobile-drawer-links a:hover, .mobile-drawer-links button:hover { color: var(--text-primary); background: var(--bg-secondary); }
        .mobile-drawer .theme-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; color: var(--text-secondary); font-size: 13px; margin-bottom: 20px; }

        .app-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 1rem;
            padding-top: calc(60px + 1rem);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .nav-right .theme-switcher { display: none; }
            .logo-dropdown { display: none !important; }
        }
        @media (min-width: 769px) {
            .mobile-drawer { display: none !important; }
            .mobile-backdrop { display: none !important; }
        }
    </style>
</head>
<body>
    <!-- Nav -->
    <nav class="nav">
        <div class="nav-inner">
            <div class="nav-left">
                <div class="nav-logo" id="navLogo">
                    AskAdjo
                    <span class="nav-logo-chevron">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </span>
                </div>
                <!-- Desktop dropdown -->
                <div class="logo-dropdown" id="logoDropdown">
                    <a href="{{ route('coach') }}" class="dropdown-link">Coach</a>
                    <a href="{{ route('settings') }}" class="dropdown-link">Settings</a>
                    <div class="logo-dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button type="submit" class="dropdown-link">Log out</button>
                    </form>
                </div>
            </div>
            <div class="nav-right">
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
            </div>
        </div>
    </nav>

    <!-- Mobile backdrop -->
    <div class="mobile-backdrop" id="mobileBackdrop"></div>

    <!-- Mobile drawer -->
    <div class="mobile-drawer" id="mobileDrawer">
        <div class="mobile-drawer-header">
            <span class="mobile-drawer-logo">AskAdjo</span>
            <button class="mobile-drawer-close" id="drawerClose" aria-label="Close menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="mobile-drawer-body">
            <ul class="mobile-drawer-links">
                <li><a href="{{ route('coach') }}" class="mobile-link">Coach</a></li>
                <li><a href="{{ route('settings') }}" class="mobile-link">Settings</a></li>
            </ul>
            <div class="theme-row">
                <span>Theme</span>
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
            </div>
            <ul class="mobile-drawer-links" style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 0;">
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button type="submit" class="mobile-link">Log out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

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

        // ── Logo dropdown / mobile drawer ──
        var navLogo = document.getElementById('navLogo');
        var logoDropdown = document.getElementById('logoDropdown');
        var mobileDrawer = document.getElementById('mobileDrawer');
        var mobileBackdrop = document.getElementById('mobileBackdrop');
        var drawerClose = document.getElementById('drawerClose');
        var isMobile = function() { return window.innerWidth <= 768; };

        function openDrawer() {
            mobileDrawer.classList.add('open');
            mobileBackdrop.classList.add('open');
            navLogo.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            mobileDrawer.classList.remove('open');
            mobileBackdrop.classList.remove('open');
            navLogo.classList.remove('open');
            document.body.style.overflow = '';
        }
        navLogo.addEventListener('click', function(e) {
            e.stopPropagation();
            if (isMobile()) {
                mobileDrawer.classList.contains('open') ? closeDrawer() : openDrawer();
            } else {
                navLogo.classList.toggle('open');
                logoDropdown.classList.toggle('open');
            }
        });
        mobileBackdrop.addEventListener('click', closeDrawer);
        drawerClose.addEventListener('click', closeDrawer);
        document.addEventListener('click', function(e) {
            if (!navLogo.contains(e.target) && !logoDropdown.contains(e.target)) {
                navLogo.classList.remove('open');
                logoDropdown.classList.remove('open');
            }
        });
        function closeAll() { navLogo.classList.remove('open'); logoDropdown.classList.remove('open'); closeDrawer(); }
        document.querySelectorAll('.dropdown-link, .mobile-link').forEach(function(link) { link.addEventListener('click', closeAll); });
    </script>
</body>
</html>
