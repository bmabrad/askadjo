<x-layouts.guest>
    <div style="text-align: center;">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Here's how it works</h2>

        <div style="text-align: left; margin-bottom: 2rem;">
            <div style="margin-bottom: 1.25rem; display: flex; gap: 0.75rem; align-items: flex-start;">
                <span style="color: var(--text-muted); font-weight: 700; font-size: 1.25rem;">1</span>
                <div>
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">Screenshot your conversation</div>
                    <div style="font-size: 0.875rem; color: var(--text-secondary);">Upload a screenshot or paste the text from any dating app or DM.</div>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem; display: flex; gap: 0.75rem; align-items: flex-start;">
                <span style="color: var(--text-muted); font-weight: 700; font-size: 1.25rem;">2</span>
                <div>
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">Get coached</div>
                    <div style="font-size: 0.875rem; color: var(--text-secondary);">Get a read on the situation, what principles apply, and 2-3 reply options with strategy explanations.</div>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                <span style="color: var(--text-muted); font-weight: 700; font-size: 1.25rem;">3</span>
                <div>
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">Copy and send</div>
                    <div style="font-size: 0.875rem; color: var(--text-secondary);">Tap to copy a reply, switch back to your conversation, and send.</div>
                </div>
            </div>
        </div>

        <a href="{{ route('coach') }}" class="btn-primary" style="display: inline-block; text-decoration: none; line-height: 48px; width: 100%;">Start Coaching</a>
    </div>
</x-layouts.guest>
