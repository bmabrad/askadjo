<div>
    <style>@keyframes spin{to{transform:rotate(360deg)}}</style>
    {{-- Contact Selector (hidden in chat mode) --}}
    @unless($chatMode || $contactLocked)
        @if($contactId)
            @php $selectedContact = $contacts->firstWhere('id', $contactId) @endphp
            <div style="margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem">
                <span style="background:var(--pill-bg);border:1px solid var(--pill-border);border-radius:20px;padding:0.375rem 0.75rem;font-size:0.875rem;color:var(--pill-text)">
                    {{ $selectedContact?->name ?? 'Contact' }}
                    <button wire:click="clearContact" style="background:none;border:none;color:var(--text-muted);cursor:pointer;margin-left:0.25rem">&times;</button>
                </span>
            </div>
        @else
            <div style="margin-bottom:1rem">
                <select wire:change="selectContact($event.target.value)" style="width:100%;height:48px;padding:0 0.75rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none">
                    <option value="">Select a contact...</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->platform->name }})</option>
                    @endforeach
                </select>
                @error('contactId') <div style="font-size:0.8125rem;color:var(--error);margin-top:0.25rem">{{ $message }}</div> @enderror
            </div>
        @endif
    @endunless

    @if($error)
        <div style="font-size:0.875rem;color:var(--error);text-align:center;padding:0.625rem 1rem;margin-bottom:0.75rem;background:rgba(255,107,107,0.1);border:1px solid rgba(255,107,107,0.2);border-radius:8px">{{ $error }}</div>
    @endif

    @if($isSubmitting)
        {{-- Disabled input while submitting --}}
        <div style="display:flex;gap:0.5rem;align-items:flex-end;margin-bottom:0.75rem;opacity:0.5;pointer-events:none">
            <textarea disabled placeholder="Waiting for coach..." rows="2" style="flex:1;padding:0.75rem 1rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-muted);outline:none;resize:vertical;font-family:inherit;min-height:48px"></textarea>
        </div>
    @else
        @error('screenshots.*') <div style="font-size:0.8125rem;color:var(--error);margin-bottom:0.5rem">{{ $message }}</div> @enderror
        @error('screenshots') <div style="font-size:0.8125rem;color:var(--error);margin-bottom:0.5rem">{{ $message }}</div> @enderror

        {{-- Smart Paste Input --}}
        <div
            x-data="{
                hasImages: false,
                submitted: false,
                uploading: false,
                handlePaste(e) {
                    const items = e.clipboardData?.items;
                    if (!items) return;
                    for (const item of items) {
                        if (item.type.startsWith('image/')) {
                            e.preventDefault();
                            const file = item.getAsFile();
                            if (file) {
                                this.hasImages = true;
                                this.uploading = true;
                                const dt = new DataTransfer();
                                dt.items.add(file);
                                $refs.fileInput.files = dt.files;
                                $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                            return;
                        }
                    }
                },
                dispatchStarted() {
                    const text = $wire.get('textInput') || '';
                    const screenshots = [];
                    document.querySelectorAll('[data-pending-thumb]').forEach(img => {
                        if (img.src) screenshots.push(img.src);
                    });
                    window.dispatchEvent(new CustomEvent('coaching-started', { detail: { text: text.trim() || null, screenshots } }));
                    // Clear UI immediately but DON'T clear Livewire state — submit() needs it
                    $refs.mainInput.value = '';
                    this.hasImages = false;
                    this.submitted = true;
                },
                canSubmit() {
                    const text = ($wire.get('textInput') || '').trim();
                    return (text.length > 0 || this.hasImages) && !this.uploading;
                },
                handleKeydown(e) {
                    if (e.key === 'Enter' && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
                        e.preventDefault();
                        if (this.canSubmit()) {
                            this.dispatchStarted();
                            $wire.submit();
                        }
                    }
                }
            }"
            x-init="$nextTick(() => $refs.mainInput?.focus())"
            @coach-response-received.window="submitted = false; hasImages = false; $nextTick(() => $refs.mainInput?.focus())"
            @coaching-failed.window="submitted = false"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false"
            x-on:livewire-upload-error="uploading = false"
        >
            {{-- Screenshot Thumbnails (hidden after submit) --}}
            @if(count($screenshots) > 0)
                <div x-show="!submitted" x-cloak style="display:flex;gap:0.5rem;margin-bottom:0.75rem;overflow-x:auto">
                    @foreach($screenshots as $index => $screenshot)
                        <div style="position:relative;flex-shrink:0;width:60px;height:60px;border-radius:8px;overflow:hidden;border:1px solid var(--border)">
                            @if($screenshot && method_exists($screenshot, 'temporaryUrl') && $screenshot->isPreviewable())
                                <img data-pending-thumb src="{{ $screenshot->temporaryUrl() }}" style="width:100%;height:100%;object-fit:cover" alt="Screenshot {{ $index + 1 }}">
                            @endif
                            <button wire:click="removeScreenshot({{ $index }})" style="position:absolute;top:2px;right:2px;width:18px;height:18px;background:rgba(0,0,0,0.7);border:none;border-radius:50%;color:white;font-size:10px;cursor:pointer;display:flex;align-items:center;justify-content:center">&times;</button>
                        </div>
                    @endforeach
                </div>
            @endif

            <div style="display:flex;gap:0.5rem;align-items:flex-end;margin-bottom:0.75rem">
                <textarea
                    x-ref="mainInput"
                    wire:model="textInput"
                    @paste="handlePaste($event)"
                    @keydown="handleKeydown($event)"
                    placeholder="Paste or type here..."
                    rows="2"
                    style="flex:1;padding:0.75rem 1rem;font-size:16px;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;color:var(--text-primary);outline:none;resize:vertical;font-family:inherit;min-height:48px"
                ></textarea>
                <label style="flex-shrink:0;width:48px;height:48px;display:flex;align-items:center;justify-content:center;background:var(--bg-input);border:1px solid var(--border);border-radius:8px;cursor:pointer;color:var(--text-muted);font-size:1.25rem">
                    📎
                    <input type="file" wire:model="screenshots" accept="image/jpeg,image/png,image/webp" multiple style="display:none" x-ref="fileInput" @change="hasImages = $el.files.length > 0; uploading = true">
                </label>
            </div>

            {{-- Image upload indicator --}}
            <div x-show="uploading" x-cloak style="display:flex;align-items:center;gap:0.5rem;padding:0.5rem 0;margin-bottom:0.5rem">
                <svg style="width:16px;height:16px;color:var(--text-muted);animation:spin 1s linear infinite" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="12"/></svg>
                <span style="font-size:0.8125rem;color:var(--text-muted)">Uploading image...</span>
            </div>

            @error('textInput') <div style="font-size:0.8125rem;color:var(--error);margin-bottom:0.5rem">{{ $message }}</div> @enderror

            {{-- Submit --}}
            <button @click="dispatchStarted(); $wire.submit()" style="width:100%;height:48px;font-size:1rem;font-weight:600;background:var(--btn-primary-bg);color:var(--btn-primary-text);border:none;border-radius:8px;cursor:pointer">Ask Me</button>

        </div>
    @endif
</div>
