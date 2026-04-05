<div>
    @include('partials.page-header', ['title' => 'Settings'])

    {{-- Profile Section --}}
    <livewire:settings.update-profile />

    <div style="height:1px;background:var(--border);margin:1.5rem 0"></div>

    {{-- Password Section --}}
    <livewire:settings.update-password />

    <div style="height:1px;background:var(--border);margin:1.5rem 0"></div>

    {{-- Logout --}}
    <div style="margin-bottom:1.5rem">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="width:100%;height:48px;font-size:0.9375rem;font-weight:600;background:var(--btn-secondary-bg);border:1px solid var(--btn-secondary-border);border-radius:8px;color:var(--btn-secondary-text);cursor:pointer">Log Out</button>
        </form>
    </div>

    <div style="height:1px;background:var(--border);margin:1.5rem 0"></div>

    {{-- Danger Zone --}}
    <livewire:settings.delete-account />
</div>
