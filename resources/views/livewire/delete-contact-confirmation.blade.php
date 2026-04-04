<div>
    @if($show)
    <div style="position:fixed;inset:0;background:rgba(0,0,0,0.6);display:flex;align-items:center;justify-content:center;z-index:50;padding:1rem">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.5rem;width:100%;max-width:400px">
            <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:0.75rem">Delete Contact</h3>
            <p style="font-size:0.875rem;color:var(--text-secondary);margin-bottom:1.5rem">
                This will permanently delete {{ $contact?->name }} and all coaching history. Are you sure?
            </p>

            <div style="display:flex;gap:0.75rem">
                <button wire:click="close" type="button" style="flex:1;height:44px;background:transparent;border:1px solid var(--btn-secondary-border);border-radius:8px;color:var(--btn-secondary-text);cursor:pointer;font-size:0.875rem">Cancel</button>
                <button wire:click="confirm" type="button" style="flex:1;height:44px;background:var(--btn-danger-bg);color:var(--btn-danger-text);border:none;border-radius:8px;cursor:pointer;font-weight:600;font-size:0.875rem">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
