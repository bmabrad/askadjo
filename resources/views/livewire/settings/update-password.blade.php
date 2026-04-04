<div>
    <h2 style="font-size:0.875rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.75rem">Password</h2>

    @if($successMessage)
        <div style="margin-bottom:0.75rem;padding:0.5rem 0.75rem;background:var(--bg-hover);border-radius:8px;font-size:0.8125rem;color:var(--success)">{{ $successMessage }}</div>
    @endif

    <div style="margin-bottom:0.75rem">
        <input type="password" wire:model="current_password" placeholder="Current password" style="width:100%;height:48px;padding:0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none">
        @error('current_password') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
    </div>

    <div style="margin-bottom:0.75rem">
        <input type="password" wire:model="password" placeholder="New password" style="width:100%;height:48px;padding:0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none">
        @error('password') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
    </div>

    <div style="margin-bottom:0.75rem">
        <input type="password" wire:model="password_confirmation" placeholder="Confirm new password" style="width:100%;height:48px;padding:0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none">
    </div>

    <button wire:click="save" style="width:100%;height:48px;font-size:0.9375rem;font-weight:600;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;border-radius:8px;cursor:pointer">Update Password</button>
</div>
