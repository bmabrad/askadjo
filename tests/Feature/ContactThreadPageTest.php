<?php

use App\Models\Contact;
use App\Models\User;

it('loads the contact thread page for the owner', function () {
    $user = User::factory()->create();
    $contact = Contact::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('contacts.show', $contact))
        ->assertOk();
});

it('requires authentication', function () {
    $contact = Contact::factory()->create();

    $this->get(route('contacts.show', $contact))
        ->assertRedirect(route('login'));
});

it('returns 403 for non-owner', function () {
    $contact = Contact::factory()->create();
    $otherUser = User::factory()->create();

    $this->actingAs($otherUser)
        ->get(route('contacts.show', $contact))
        ->assertForbidden();
});
