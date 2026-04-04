<?php

namespace App\Livewire;

use App\Enums\Platform;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateContactModal extends Component
{
    public string $name = '';
    public string $platform = '';
    public bool $show = false;

    #[On('open-create-modal')]
    public function openFromEvent(): void
    {
        $this->open();
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'platform' => ['required', 'string', \Illuminate\Validation\Rule::enum(Platform::class)],
        ];
    }

    public function open(): void
    {
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->reset(['name', 'platform']);
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $contact = auth()->user()->contacts()->create([
            'name' => $this->name,
            'platform' => $this->platform,
        ]);

        $this->dispatch('contact-created', contactId: $contact->id);
        $this->close();
    }

    public function render()
    {
        return view('livewire.create-contact-modal', [
            'platforms' => Platform::cases(),
        ]);
    }
}
