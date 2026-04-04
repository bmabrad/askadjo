<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AskAdjo — Stop guessing. Start sending.</title>
    <script>
        (function(){
            var t;try{t=localStorage.getItem('askadjo-theme')}catch(e){}
            if(!t)t='dark';
            var r=t==='system'?(window.matchMedia('(prefers-color-scheme:dark)').matches?'dark':'light'):t;
            document.documentElement.setAttribute('data-theme',r);
        })();
    </script>
    <style>
        /* ── Theme tokens ── */
        :root {
            --transition-speed: 0.25s;
            --accent: #d97757;
            --accent-hover: #c4684b;
            --radius: 10px;
            --radius-sm: 6px;
        }

        [data-theme="dark"] {
            --bg-primary: #131314;
            --bg-secondary: #1a1a1c;
            --bg-card: #1e1e20;
            --bg-nav: rgba(19, 19, 20, 0.85);
            --text-primary: #ececec;
            --text-secondary: #a0a0a0;
            --text-muted: #666666;
            --border: #2a2a2c;
            --border-hover: #3a3a3c;
            --btn-primary-bg: #ececec;
            --btn-primary-text: #131314;
            --btn-secondary-bg: transparent;
            --btn-secondary-border: #3a3a3c;
            --btn-secondary-text: #ececec;
        }

        [data-theme="light"] {
            --bg-primary: #fafaf9;
            --bg-secondary: #f0efed;
            --bg-card: #ffffff;
            --bg-nav: rgba(250, 250, 249, 0.85);
            --text-primary: #1a1a1a;
            --text-secondary: #6b6b6b;
            --text-muted: #999999;
            --border: #e5e4e2;
            --border-hover: #d0cfcc;
            --btn-primary-bg: #1a1a1a;
            --btn-primary-text: #fafaf9;
            --btn-secondary-bg: transparent;
            --btn-secondary-border: #d0cfcc;
            --btn-secondary-text: #1a1a1a;
        }

        /* ── Reset ── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }

        a { color: inherit; text-decoration: none; }

        /* ── Nav ── */
        .nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: var(--bg-nav); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); transition: background-color var(--transition-speed), border-color var(--transition-speed); }
        .nav-inner { max-width: 1080px; margin: 0 auto; padding: 0 24px; height: 60px; display: flex; align-items: center; justify-content: space-between; }
        .nav-left { position: relative; }
        .nav-logo { display: flex; align-items: center; gap: 8px; font-size: 20px; font-weight: 800; letter-spacing: -0.3px; cursor: pointer; user-select: none; padding: 4px 0; }
        .nav-logo-chevron { display: inline-flex; align-items: center; transition: transform 0.2s; }
        .nav-logo-chevron svg { width: 14px; height: 14px; }
        .nav-logo.open .nav-logo-chevron { transform: rotate(180deg); }

        /* Desktop dropdown */
        .logo-dropdown { position: absolute; top: calc(100% + 8px); left: 0; min-width: 160px; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 8px 24px rgba(0,0,0,0.2); opacity: 0; visibility: hidden; transform: translateY(-4px); transition: opacity 0.2s, visibility 0.2s, transform 0.2s, background-color var(--transition-speed), border-color var(--transition-speed); padding: 4px; z-index: 110; }
        .logo-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .logo-dropdown a { display: block; padding: 7px 12px; font-size: 13px; font-weight: 500; color: var(--text-secondary); border-radius: var(--radius-sm); transition: color 0.15s, background-color 0.15s; }
        .logo-dropdown a:hover { color: var(--text-primary); background: var(--bg-secondary); }
        .logo-dropdown-divider { height: 1px; background: var(--border); margin: 4px 0; }

        .nav-right { display: flex; align-items: center; gap: 12px; }

        /* Theme switcher */
        .theme-switcher { display: flex; align-items: center; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 20px; padding: 3px; gap: 2px; }
        .theme-btn { display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 50%; background: transparent; color: var(--text-muted); cursor: pointer; transition: color 0.15s, background-color 0.15s; }
        .theme-btn:hover { color: var(--text-secondary); }
        .theme-btn.active { background: var(--bg-card); color: var(--text-primary); box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .theme-btn svg { width: 16px; height: 16px; }

        .btn-nav { font-size: 14px; font-weight: 500; padding: 8px 18px; border-radius: var(--radius-sm); border: 1px solid var(--btn-secondary-border); background: var(--btn-secondary-bg); color: var(--btn-secondary-text); cursor: pointer; transition: border-color 0.15s, background-color 0.15s; text-decoration: none; display: inline-block; }
        .btn-nav:hover { border-color: var(--text-muted); }
        .btn-nav-primary { background: var(--btn-primary-bg); color: var(--btn-primary-text); border-color: var(--btn-primary-bg); }
        .btn-nav-primary:hover { opacity: 0.9; border-color: var(--btn-primary-bg); }

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
        .mobile-drawer-links a { display: block; padding: 10px 12px; font-size: 15px; font-weight: 500; color: var(--text-secondary); border-radius: var(--radius-sm); transition: color 0.15s, background-color 0.15s; }
        .mobile-drawer-links a:hover { color: var(--text-primary); background: var(--bg-secondary); }
        .mobile-drawer .theme-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; color: var(--text-secondary); font-size: 13px; margin-bottom: 20px; }
        .mobile-drawer-actions { display: flex; flex-direction: column; gap: 10px; padding-top: 16px; border-top: 1px solid var(--border); }
        .mobile-drawer-actions a { display: block; text-align: center; padding: 12px; font-size: 15px; font-weight: 600; border-radius: var(--radius); text-decoration: none; }

        /* ── Containers ── */
        .container { max-width: 760px; margin: 0 auto; padding: 0 24px; }
        .container-wide { max-width: 1080px; margin: 0 auto; padding: 0 24px; }

        /* ── Hero ── */
        .hero { text-align: center; padding: 140px 0 80px; }
        .hero-badge { display: inline-block; font-size: 13px; font-weight: 500; color: var(--accent); background: transparent; border: 1px solid var(--accent); border-radius: 20px; padding: 6px 16px; margin-bottom: 28px; letter-spacing: 0.02em; }
        .headline { font-size: 52px; font-weight: 700; line-height: 1.1; letter-spacing: -1.5px; margin-bottom: 20px; }
        .subhead { font-size: 19px; color: var(--text-secondary); max-width: 480px; margin: 0 auto 40px; line-height: 1.55; }
        .hero-actions { display: flex; align-items: center; justify-content: center; gap: 16px; flex-wrap: wrap; }

        .btn-primary { display: inline-flex; align-items: center; gap: 8px; background: var(--btn-primary-bg); color: var(--btn-primary-text); font-size: 16px; font-weight: 600; padding: 14px 32px; border-radius: var(--radius); text-decoration: none; min-height: 48px; transition: opacity 0.15s, transform 0.15s; border: none; cursor: pointer; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: scale(0.98); }
        .btn-secondary { display: inline-flex; align-items: center; gap: 8px; background: var(--btn-secondary-bg); color: var(--btn-secondary-text); font-size: 16px; font-weight: 500; padding: 14px 32px; border-radius: var(--radius); text-decoration: none; min-height: 48px; border: 1px solid var(--btn-secondary-border); transition: border-color 0.15s, transform 0.15s; cursor: pointer; }
        .btn-secondary:hover { border-color: var(--text-muted); transform: translateY(-1px); }

        /* ── Sections ── */
        .section { padding: 80px 0; }
        .section-label { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: var(--accent); text-align: center; margin-bottom: 12px; }
        .section-title { font-size: 36px; font-weight: 700; text-align: center; margin-bottom: 16px; letter-spacing: -0.8px; line-height: 1.15; }
        .section-subtitle { font-size: 17px; color: var(--text-secondary); text-align: center; max-width: 520px; margin: 0 auto 48px; line-height: 1.5; }

        /* ── Steps ── */
        .steps { list-style: none; display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .step { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 32px 24px; transition: border-color 0.2s, transform 0.2s, background-color var(--transition-speed); }
        .step:hover { border-color: var(--border-hover); transform: translateY(-2px); }
        .step-number { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background: var(--bg-secondary); font-weight: 700; font-size: 13px; color: var(--text-secondary); margin-bottom: 16px; transition: background-color var(--transition-speed); }
        .step-title { font-weight: 600; font-size: 17px; margin-bottom: 8px; }
        .step-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.55; }

        /* ── Features ── */
        .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .feature { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 32px 24px; transition: border-color 0.2s, transform 0.2s, background-color var(--transition-speed); }
        .feature:hover { border-color: var(--border-hover); transform: translateY(-2px); }
        .feature-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--bg-secondary); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; color: var(--accent); transition: background-color var(--transition-speed); }
        .feature-icon svg { width: 20px; height: 20px; }
        .feature-title { font-weight: 600; font-size: 17px; margin-bottom: 8px; }
        .feature-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.55; }

        /* ── Bottom CTA ── */
        .bottom-cta { text-align: center; padding: 80px 0 100px; }
        .bottom-cta .section-title { margin-bottom: 12px; }
        .bottom-cta .section-subtitle { margin-bottom: 36px; }

        /* ── Footer ── */
        .footer { border-top: 1px solid var(--border); padding: 32px 0; transition: border-color var(--transition-speed); }
        .footer-inner { max-width: 1080px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; }
        .footer-text { font-size: 13px; color: var(--text-muted); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .nav-right .btn-nav { display: none; }
            .nav-right .theme-switcher { display: none; }
            .hero { padding: 110px 0 60px; }
            .headline { font-size: 36px; letter-spacing: -0.8px; }
            .subhead { font-size: 17px; }
            .section { padding: 60px 0; }
            .section-title { font-size: 28px; }
            .steps { grid-template-columns: 1fr; gap: 16px; }
            .features { grid-template-columns: 1fr; gap: 16px; }
            .step, .feature { padding: 24px 20px; }
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
                    <div class="logo-dropdown-divider"></div>
                    <a href="{{ route('login') }}" class="dropdown-link">Log in</a>
                    <a href="{{ route('register') }}" class="dropdown-link">Sign up</a>
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
                <a href="{{ route('login') }}" class="btn-nav">Log in</a>
                <a href="{{ route('register') }}" class="btn-nav btn-nav-primary">Sign up</a>
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
            <div class="mobile-drawer-actions">
                <a href="{{ route('login') }}" style="color: var(--text-primary); border: 1px solid var(--border); border-radius: var(--radius);">Log in</a>
                <a href="{{ route('register') }}" style="background: var(--btn-primary-bg); color: var(--btn-primary-text); border-radius: var(--radius);">Sign up</a>
            </div>
        </div>
    </div>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <div class="hero-badge">AI-powered coaching</div>
            <h1 class="headline">Stop guessing.<br>Start sending.</h1>
            <p class="subhead">Paste a dating conversation. Get tactical advice from an AI coach grounded in real psychology, not generic tips.</p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-primary">Get started free</a>
                <a href="#how-it-works" class="btn-secondary">See how it works</a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="section" id="how-it-works">
        <div class="container-wide">
            <div class="section-label">How It Works</div>
            <h2 class="section-title">Three steps. One better reply.</h2>
            <p class="section-subtitle">No sign-up quiz. No personality test. Just paste your conversation and get coached.</p>
            <ol class="steps">
                <li class="step">
                    <span class="step-number">1</span>
                    <div class="step-title">Paste or screenshot</div>
                    <div class="step-desc">Drop in the chat from any app. Tinder, Bumble, Hinge, iMessage, WhatsApp, whatever.</div>
                </li>
                <li class="step">
                    <span class="step-number">2</span>
                    <div class="step-title">Get the read</div>
                    <div class="step-desc">Your coach breaks down what's actually happening. Who's chasing, what frame she's setting, where you stand.</div>
                </li>
                <li class="step">
                    <span class="step-number">3</span>
                    <div class="step-title">Pick and send</div>
                    <div class="step-desc">Choose from ready-to-send replies. Copy, paste, done. Each one explains the strategy behind it.</div>
                </li>
            </ol>
        </div>
    </section>

    <!-- Features -->
    <section class="section" id="features" style="background: var(--bg-secondary); transition: background-color var(--transition-speed);">
        <div class="container-wide">
            <div class="section-label">What You Get</div>
            <h2 class="section-title">Not a chatbot. A coach.</h2>
            <p class="section-subtitle">Every response is grounded in a structured methodology, not vibes.</p>
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <div class="feature-title">Situation read</div>
                    <div class="feature-desc">A real breakdown of what's going on. What she's signalling, what the power dynamic is, and what your position looks like.</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="feature-title">Reply options</div>
                    <div class="feature-desc">Multiple replies written for your specific conversation. Not templates. Ready to copy and send.</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <div class="feature-title">The why</div>
                    <div class="feature-desc">Every suggestion explains the principle behind it. So you're learning to read conversations yourself, not just following instructions.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="bottom-cta">
        <div class="container">
            <div class="section-label">Ready?</div>
            <h2 class="section-title">Stop overthinking that text.</h2>
            <p class="section-subtitle">Get your first coaching session in under a minute.</p>
            <a href="{{ route('register') }}" class="btn-primary">Create your account</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <span class="footer-text">AskAdjo</span>
            <span class="footer-text">&copy; 2026</span>
        </div>
    </footer>

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
        document.querySelectorAll('a[href^="#"]').forEach(function(a) {
            a.addEventListener('click', function(e) {
                var target = document.querySelector(this.getAttribute('href'));
                if (target) { e.preventDefault(); closeAll(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
            });
        });
    </script>

</body>
</html>
