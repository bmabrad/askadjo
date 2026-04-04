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
        }
        [data-theme="light"] {
            --bg-primary: #fafaf9;
            --bg-secondary: #f0efed;
            --bg-card: #ffffff;
            --bg-input: #f5f5f4;
            --bg-hover: #eaeae8;
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
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            transition: background-color var(--transition-speed), color var(--transition-speed);
        }
        .guest-container {
            width: 100%;
            max-width: 420px;
        }
        .logo {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--text-primary);
        }
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            height: 48px;
            padding: 0 1rem;
            font-size: 16px;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-primary);
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            border-color: var(--border-focus);
        }
        .form-input::placeholder {
            color: var(--text-muted);
        }
        .form-error {
            font-size: 0.8125rem;
            color: var(--error);
            margin-top: 0.375rem;
        }
        .btn-primary {
            display: block;
            width: 100%;
            height: 48px;
            font-size: 1rem;
            font-weight: 600;
            background: var(--btn-primary-bg);
            color: var(--btn-primary-text);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        .form-footer a {
            color: var(--text-primary);
            text-decoration: none;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
        .alert-success {
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <div class="guest-container">
        <div class="logo">AskAdjo</div>
        <div class="card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
