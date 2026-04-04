<?php

use App\Livewire\Settings\UpdateProfile;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can update name', function () {
    Livewire::test(UpdateProfile::class)
        ->set('name', 'New Name')
        ->call('save')
        ->assertHasNoErrors();

    expect($this->user->fresh()->name)->toBe('New Name');
});

it('can update email', function () {
    Livewire::test(UpdateProfile::class)
        ->set('email', 'newemail@example.com')
        ->call('save')
        ->assertHasNoErrors();

    expect($this->user->fresh()->email)->toBe('newemail@example.com');
});

it('requires unique email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    Livewire::test(UpdateProfile::class)
        ->set('email', 'taken@example.com')
        ->call('save')
        ->assertHasErrors('email');
});

it('shows success message after save', function () {
    Livewire::test(UpdateProfile::class)
        ->call('save')
        ->assertSet('successMessage', 'Profile updated.');
});
