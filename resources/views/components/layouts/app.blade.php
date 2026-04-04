<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Collaborate AI') }}</title>
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg-primary: #0F0F0F;
            --bg-card: #1A1A1A;
            --bg-input: #252525;
            --bg-hover: #2A2A2A;
            --text-primary: #E5E5E5;
            --text-secondary: #999999;
            --text-muted: #555555;
            --border: #333333;
            --border-focus: #777777;
            --btn-primary-bg: #E5E5E5;
            --btn-primary-text: #0F0F0F;
            --btn-secondary-bg: transparent;
            --btn-secondary-border: #555555;
            --btn-secondary-text: #E5E5E5;
            --btn-danger-bg: #555555;
            --btn-danger-text: #E5E5E5;
            --success: #CCCCCC;
            --error: #FF6B6B;
            --recommended-border: #777777;
            --pill-bg: #252525;
            --pill-border: #444444;
            --pill-text: #CCCCCC;
            --coach-bubble: #1A3A5C;
            --coach-bubble-border: #1E4A6E;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            font-size: 16px;
        }
        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            background: var(--bg-card) !important;
            min-height: 56px;
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
        <a href="{{ route('dashboard') }}" class="logo" style="text-decoration:none;color:var(--text-primary)">Collaborate.ai</a>
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
