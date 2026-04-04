<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;

class DeleteContactConfirmation extends Component
{
    public ?Contact $contact = null;
    public bool $show = false;

    public function open(Contact $contact): void
    {
        $this->authorize('delete', $contact);

        $this->contact = $contact;
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->reset('contact');
    }

    public function confirm(): void
    {
        $this->contact->delete();

        $this->dispatch('contact-deleted');
        $this->close();
    }

    public function render()
    {
        return view('livewire.delete-contact-confirmation');
    }
}
