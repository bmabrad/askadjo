@props(['title', 'showClose' => true])

<div x-data style="display:flex;align-items:center;padding:0 10px 12px;border-bottom:1px solid var(--border-card)">
    {{-- Back arrow — opens slide-out menu --}}
    <button
        @click="$dispatch('toggle-slide-menu')"
        style="background:none;border:none;cursor:pointer;color:var(--brand-gold);font-size:22px;font-weight:400;padding:0;min-width:44px;min-height:44px;display:flex;align-items:center;justify-content:center"
        aria-label="Open menu"
    >&lsaquo;</button>

    {{-- Page title --}}
    <span style="font-size:18px;font-weight:800;color:var(--text-primary);letter-spacing:0.5px;margin-left:8px">{{ $title }}</span>

    @if($showClose)
        {{-- Close button — navigates to Strat Chat --}}
        <a
            href="{{ route('strat-chat') }}"
            style="margin-left:auto;color:var(--close-color);text-decoration:none;font-size:20px;min-width:44px;min-height:44px;display:flex;align-items:center;justify-content:center"
            aria-label="Close"
        >&times;</a>
    @endif
</div>
