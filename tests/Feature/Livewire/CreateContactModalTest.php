<?php

use App\Livewire\CreateContactModal;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the component', function () {
    Livewire::test(CreateContactModal::class)
        ->assertOk();
});

it('validates input on save', function () {
    Livewire::test(CreateContactModal::class)
        ->set('show', true)
        ->call('save')
        ->assertHasErrors(['name', 'platform']);
});

it('creates a contact and dispatches event', function () {
    Livewire::test(CreateContactModal::class)
        ->set('show', true)
        ->set('name', 'Sarah')
        ->set('platform', 'tinder')
        ->call('save')
        ->assertDispatched('contact-created')
        ->assertSet('show', false);

    $this->assertDatabaseHas('contacts', ['name' => 'Sarah']);
});
