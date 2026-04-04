<div>
    @if($show)
    <div style="position:fixed;inset:0;background:rgba(0,0,0,0.6);display:flex;align-items:center;justify-content:center;z-index:50;padding:1rem">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.5rem;width:100%;max-width:400px">
            <h3 style="font-size:1.125rem;font-weight:700;margin-bottom:1.25rem">Edit Contact</h3>

            <div style="margin-bottom:1rem">
                <label style="display:block;font-size:0.875rem;color:var(--text-secondary);margin-bottom:0.375rem">Name</label>
                <input wire:model="name" type="text" style="width:100%;height:48px;padding:0 1rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none">
                @error('name') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:1rem">
                <label style="display:block;font-size:0.875rem;color:var(--text-secondary);margin-bottom:0.375rem">Platform</label>
                <select wire:model="platform" style="width:100%;height:48px;padding:0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none">
                    @foreach($platforms as $p)
                        <option value="{{ $p->value }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                @error('platform') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
            </div>

            <div style="margin-bottom:1.5rem">
                <label style="display:block;font-size:0.875rem;color:var(--text-secondary);margin-bottom:0.375rem">Notes</label>
                <textarea wire:model="notes" placeholder="Private notes about this person" style="width:100%;min-height:80px;padding:0.75rem 1rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none;resize:vertical;font-family:inherit"></textarea>
                @error('notes') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:0.75rem">
                <button wire:click="close" type="button" style="flex:1;height:44px;background:transparent;border:1px solid var(--btn-secondary-border);border-radius:8px;color:var(--btn-secondary-text);cursor:pointer;font-size:0.875rem">Cancel</button>
                <button wire:click="save" type="button" style="flex:1;height:44px;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;border-radius:8px;cursor:pointer;font-weight:600;font-size:0.875rem">Save</button>
            </div>
        </div>
    </div>
    @endif
</div>
