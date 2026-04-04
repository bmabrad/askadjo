<?php

namespace App\Livewire;

use App\Enums\Platform;
use App\Models\Contact;
use Livewire\Component;

class EditContactModal extends Component
{
    public ?Contact $contact = null;
    public string $name = '';
    public string $platform = '';
    public string $notes = '';
    public bool $show = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'platform' => ['required', 'string', \Illuminate\Validation\Rule::enum(Platform::class)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function open(Contact $contact): void
    {
        $this->authorize('update', $contact);

        $this->contact = $contact;
        $this->name = $contact->name;
        $this->platform = $contact->platform->value;
        $this->notes = $contact->notes ?? '';
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->reset(['contact', 'name', 'platform', 'notes']);
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $this->contact->update([
            'name' => $this->name,
            'platform' => $this->platform,
            'notes' => $this->notes ?: null,
        ]);

        $this->dispatch('contact-updated');
        $this->close();
    }

    public function render()
    {
        return view('livewire.edit-contact-modal', [
            'platforms' => Platform::cases(),
        ]);
    }
}
