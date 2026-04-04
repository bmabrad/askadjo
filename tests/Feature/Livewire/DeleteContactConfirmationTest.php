<?php

use App\Livewire\DeleteContactConfirmation;
use App\Models\Contact;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders the component', function () {
    Livewire::test(DeleteContactConfirmation::class)
        ->assertOk();
});

it('deletes a contact on confirm', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(DeleteContactConfirmation::class)
        ->call('open', $contact->id)
        ->call('confirm')
        ->assertDispatched('contact-deleted');

    $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
});
