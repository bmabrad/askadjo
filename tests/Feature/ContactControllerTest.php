<?php

use App\Enums\ContactStatus;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('creates a contact', function () {
    $this->postJson(route('contacts.store'), [
        'name' => 'Sarah',
        'platform' => 'tinder',
    ])->assertStatus(201)
      ->assertJsonFragment(['name' => 'Sarah', 'platform' => 'tinder']);

    $this->assertDatabaseHas('contacts', ['name' => 'Sarah', 'user_id' => $this->user->id]);
});

it('requires name when creating', function () {
    $this->postJson(route('contacts.store'), ['platform' => 'tinder'])
        ->assertJsonValidationErrors('name');
});

it('requires valid platform', function () {
    $this->postJson(route('contacts.store'), ['name' => 'Sarah', 'platform' => 'invalid'])
        ->assertJsonValidationErrors('platform');
});

it('updates a contact', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id]);

    $this->putJson(route('contacts.update', $contact), ['name' => 'Updated Name'])
        ->assertOk()
        ->assertJsonFragment(['name' => 'Updated Name']);
});

it('denies updating another users contact', function () {
    $other = Contact::factory()->create();

    $this->putJson(route('contacts.update', $other), ['name' => 'Hacked'])
        ->assertForbidden();
});

it('archives a contact', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id]);

    $this->patchJson(route('contacts.archive', $contact))
        ->assertOk();

    expect($contact->fresh()->status)->toBe(ContactStatus::Archived);
});

it('restores a contact', function () {
    $contact = Contact::factory()->create([
        'user_id' => $this->user->id,
        'status' => ContactStatus::Archived,
    ]);

    $this->patchJson(route('contacts.restore', $contact))
        ->assertOk();

    expect($contact->fresh()->status)->toBe(ContactStatus::Active);
});

it('deletes a contact', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id]);

    $this->deleteJson(route('contacts.destroy', $contact))
        ->assertOk();

    $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
});

it('cascades delete to coaching sessions', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id]);
    $session = CoachingSession::factory()->create(['contact_id' => $contact->id]);

    $this->deleteJson(route('contacts.destroy', $contact));

    $this->assertDatabaseMissing('coaching_sessions', ['id' => $session->id]);
});

it('denies deleting another users contact', function () {
    $other = Contact::factory()->create();

    $this->deleteJson(route('contacts.destroy', $other))
        ->assertForbidden();
});
