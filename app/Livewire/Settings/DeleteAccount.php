<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DeleteAccount extends Component
{
    public bool $confirmingDeletion = false;
    public string $password = '';

    public function confirmDeletion(): void
    {
        $this->confirmingDeletion = true;
    }

    public function cancelDeletion(): void
    {
        $this->confirmingDeletion = false;
        $this->password = '';
    }

    public function deleteAccount(): void
    {
        $this->validate([
            'password' => ['required'],
        ]);

        if (! Hash::check($this->password, auth()->user()->password)) {
            $this->addError('password', 'The password is incorrect.');
            return;
        }

        $user = auth()->user();

        Auth::logout();

        $user->delete();

        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.settings.delete-account');
    }
}
