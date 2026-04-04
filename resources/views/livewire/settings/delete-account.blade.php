<div>
    <h2 style="font-size:0.875rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--error);margin-bottom:0.5rem">Danger Zone</h2>
    <p style="font-size:0.8125rem;color:var(--text-secondary);margin-bottom:0.75rem">Permanently delete your account and all data.</p>

    @if(!$confirmingDeletion)
        <button wire:click="confirmDeletion" style="width:100%;height:48px;font-size:0.9375rem;font-weight:600;background:var(--btn-danger-bg);color:var(--btn-danger-text);border:none;border-radius:8px;cursor:pointer">Delete Account</button>
    @else
        <div style="padding:1rem;background:var(--bg-card);border:1px solid var(--border);border-radius:8px">
            <h3 style="font-size:0.9375rem;font-weight:600;margin-bottom:0.5rem">Are you sure?</h3>
            <p style="font-size:0.8125rem;color:var(--text-secondary);margin-bottom:0.75rem">This will permanently delete your account, all contacts, and all coaching history.</p>

            <div style="margin-bottom:0.75rem">
                <input type="password" wire:model="password" placeholder="Confirm your password" style="width:100%;height:48px;padding:0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none">
                @error('password') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:0.5rem">
                <button wire:click="cancelDeletion" style="flex:1;height:48px;font-size:0.9375rem;background:var(--btn-secondary-bg);border:1px solid var(--btn-secondary-border);border-radius:8px;color:var(--btn-secondary-text);cursor:pointer">Cancel</button>
                <button wire:click="deleteAccount" style="flex:1;height:48px;font-size:0.9375rem;font-weight:600;background:var(--btn-danger-bg);color:var(--error);border:none;border-radius:8px;cursor:pointer">Delete Forever</button>
            </div>
        </div>
    @endif
</div>
