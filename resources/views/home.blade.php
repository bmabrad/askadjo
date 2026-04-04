<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AskAdjo — Stop guessing. Start sending.</title>
    <style>
        :root {
            --bg-primary: #0F0F0F;
            --bg-card: #1A1A1A;
            --bg-input: #252525;
            --text-primary: #E5E5E5;
            --text-secondary: #999999;
            --text-muted: #555555;
            --border: #333333;
            --btn-primary-bg: #E5E5E5;
            --btn-primary-text: #0F0F0F;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 640px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Hero */
        .hero {
            text-align: center;
            padding: 80px 0 60px;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 40px;
        }

        .headline {
            font-size: 36px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .subhead {
            font-size: 18px;
            color: var(--text-secondary);
            max-width: 420px;
            margin: 0 auto 40px;
            line-height: 1.5;
        }

        .btn-primary {
            display: inline-block;
            background: var(--btn-primary-bg);
            color: var(--btn-primary-text);
            font-size: 16px;
            font-weight: 600;
            padding: 14px 36px;
            border-radius: 8px;
            text-decoration: none;
            min-height: 44px;
            transition: opacity 0.15s;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .login-link {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .login-link a {
            color: var(--text-primary);
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        /* Sections */
        .section {
            padding: 60px 0;
            border-top: 1px solid var(--border);
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 36px;
        }

        /* How it works */
        .steps {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .step-number {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--bg-card);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .step-text {
            padding-top: 6px;
        }

        .step-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .step-desc {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Features */
        .features {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .feature {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .feature-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 6px;
        }

        .feature-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Bottom CTA */
        .bottom-cta {
            text-align: center;
            padding: 60px 0 80px;
            border-top: 1px solid var(--border);
        }

        .bottom-cta .headline {
            font-size: 28px;
            margin-bottom: 24px;
        }

        /* Mobile */
        @media (max-width: 480px) {
            .hero {
                padding: 60px 0 48px;
            }

            .headline {
                font-size: 28px;
            }

            .subhead {
                font-size: 16px;
            }

            .section {
                padding: 48px 0;
            }

            .section-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Hero -->
        <section class="hero">
            <div class="logo">AskAdjo</div>
            <h1 class="headline">Stop guessing.<br>Start sending.</h1>
            <p class="subhead">Paste a dating conversation. Get tactical advice from an AI coach grounded in real psychology, not generic tips.</p>
            <a href="{{ route('register') }}" class="btn-primary">Create Your Account</a>
            <p class="login-link">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </section>

        <!-- How It Works -->
        <section class="section">
            <h2 class="section-title">How It Works</h2>
            <ol class="steps">
                <li class="step">
                    <span class="step-number">1</span>
                    <div class="step-text">
                        <div class="step-title">Paste or screenshot your conversation</div>
                        <div class="step-desc">Drop in the chat from any app. Tinder, Bumble, Hinge, iMessage, whatever.</div>
                    </div>
                </li>
                <li class="step">
                    <span class="step-number">2</span>
                    <div class="step-text">
                        <div class="step-title">Get a read on the situation</div>
                        <div class="step-desc">Your coach breaks down what's actually happening, what she's signalling, and where you stand.</div>
                    </div>
                </li>
                <li class="step">
                    <span class="step-number">3</span>
                    <div class="step-text">
                        <div class="step-title">Pick a reply and send it</div>
                        <div class="step-desc">Choose from ready-to-send options. Copy, paste, done. Each one explains the strategy behind it.</div>
                    </div>
                </li>
            </ol>
        </section>

        <!-- What You Get -->
        <section class="section">
            <h2 class="section-title">What You Get</h2>
            <div class="features">
                <div class="feature">
                    <div class="feature-title">Situation read</div>
                    <div class="feature-desc">Not a vibe check. A real breakdown of what's going on in the conversation, what signals she's giving, and what your position is.</div>
                </div>
                <div class="feature">
                    <div class="feature-title">Reply options</div>
                    <div class="feature-desc">Multiple replies you can actually send. Not templates. Written for your specific conversation, ready to copy and paste.</div>
                </div>
                <div class="feature">
                    <div class="feature-title">The why behind each reply</div>
                    <div class="feature-desc">Every suggestion explains the principle behind it. So you're learning to read conversations yourself, not just following instructions.</div>
                </div>
            </div>
        </section>

        <!-- Bottom CTA -->
        <section class="bottom-cta">
            <h2 class="headline">Stop overthinking that text.</h2>
            <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
        </section>

    </div>
</body>
</html>
