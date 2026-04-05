<div>
    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
        <a href="{{ route('strat-chat') }}" style="color:var(--text-secondary);text-decoration:none;font-size:1.25rem">&larr;</a>
        <h1 style="font-size:1.25rem;font-weight:700;margin:0">{{ $title }}</h1>
    </div>

    {{-- Coming Soon --}}
    <div style="text-align:center;padding:3rem 1rem">
        <p style="font-size:1.125rem;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem">Coming soon</p>
        <p style="font-size:0.875rem;color:var(--text-secondary)">This section is under development.</p>
    </div>
</div>
