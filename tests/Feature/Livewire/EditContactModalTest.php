<?php

use App\Livewire\EditContactModal;
use App\Models\Contact;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders the component', function () {
    Livewire::test(EditContactModal::class)
        ->assertOk();
});

it('updates a contact', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Old Name']);

    Livewire::test(EditContactModal::class)
        ->call('open', $contact->id)
        ->set('name', 'New Name')
        ->call('save')
        ->assertDispatched('contact-updated');

    expect($contact->fresh()->name)->toBe('New Name');
});
