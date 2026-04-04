<?php

namespace App\Livewire\Settings;

use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateProfile extends Component
{
    public string $name = '';
    public string $email = '';
    public ?string $successMessage = null;

    public function mount(): void
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->successMessage = 'Profile updated.';
    }

    public function render()
    {
        return view('livewire.settings.update-profile');
    }
}
