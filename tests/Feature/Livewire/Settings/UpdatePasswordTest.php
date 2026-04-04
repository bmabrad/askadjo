<?php

use App\Livewire\Settings\UpdatePassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['password' => Hash::make('oldpassword')]);
    $this->actingAs($this->user);
});

it('can update password', function () {
    Livewire::test(UpdatePassword::class)
        ->set('current_password', 'oldpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('successMessage', 'Password updated.');

    expect(Hash::check('newpassword123', $this->user->fresh()->password))->toBeTrue();
});

it('rejects wrong current password', function () {
    Livewire::test(UpdatePassword::class)
        ->set('current_password', 'wrongpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'newpassword123')
        ->call('save')
        ->assertHasErrors('current_password');
});

it('requires password confirmation', function () {
    Livewire::test(UpdatePassword::class)
        ->set('current_password', 'oldpassword')
        ->set('password', 'newpassword123')
        ->set('password_confirmation', 'doesnotmatch')
        ->call('save')
        ->assertHasErrors('password');
});

it('enforces minimum password length', function () {
    Livewire::test(UpdatePassword::class)
        ->set('current_password', 'oldpassword')
        ->set('password', 'short')
        ->set('password_confirmation', 'short')
        ->call('save')
        ->assertHasErrors('password');
});
