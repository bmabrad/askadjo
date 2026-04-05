<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AskAdjo') }} — Welcome</title>
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
            --brand-gold: #C8943E;
            --brand-gold-light: #E8B86A;
        }
        [data-theme="dark"] {
            --bg-primary: #131314;
            --bg-secondary: #1a1a1c;
            --bg-card: #1e1e20;
            --bg-screen: #0E0E18;
            --text-primary: #F5F0E8;
            --text-secondary: #9A8A72;
            --text-muted: #8C7A5E;
            --border: #2a2a2c;
            --border-card: #2A2834;
        }
        [data-theme="light"] {
            --bg-primary: #fafaf9;
            --bg-secondary: #f0efed;
            --bg-card: #ffffff;
            --bg-screen: #F5F0E8;
            --text-primary: #1A1A2E;
            --text-secondary: #8C7A5E;
            --text-muted: #8C7A5E;
            --border: #e5e4e2;
            --border-card: #E8DCC8;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
        }
        .phone-frame {
            max-width: 430px;
            margin: 0 auto;
            min-height: 100vh;
            background: var(--bg-primary);
            border-left: 1px solid var(--border);
            border-right: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        @media (max-width: 430px) {
            .phone-frame { border-left: none; border-right: none; }
        }
    </style>
</head>
<body>
    <div class="phone-frame">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
