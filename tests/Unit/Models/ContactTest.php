<?php

use App\Enums\ContactStatus;
use App\Enums\Platform;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

it('belongs to a user', function () {
    $contact = Contact::factory()->create();

    expect($contact->user)->toBeInstanceOf(User::class);
});

it('has many coaching sessions', function () {
    $contact = Contact::factory()->create();

    expect($contact->coachingSessions)->toBeInstanceOf(Collection::class);
});

it('returns only related coaching sessions', function () {
    $contact = Contact::factory()->create();
    $session = CoachingSession::factory()->create(['contact_id' => $contact->id]);
    CoachingSession::factory()->create(); // different contact

    expect($contact->coachingSessions)->toHaveCount(1)
        ->and($contact->coachingSessions->first()->is($session))->toBeTrue();
});

it('casts platform to enum', function () {
    $contact = Contact::factory()->create(['platform' => 'tinder']);

    expect($contact->platform)->toBeInstanceOf(Platform::class)
        ->and($contact->platform)->toBe(Platform::Tinder);
});

it('casts status to enum', function () {
    $contact = Contact::factory()->create(['status' => 'active']);

    expect($contact->status)->toBeInstanceOf(ContactStatus::class)
        ->and($contact->status)->toBe(ContactStatus::Active);
});

it('filters active contacts with scope', function () {
    Contact::factory()->create(['status' => ContactStatus::Active]);
    Contact::factory()->create(['status' => ContactStatus::Archived]);

    $active = Contact::active()->get();

    expect($active)->toHaveCount(1)
        ->and($active->first()->status)->toBe(ContactStatus::Active);
});

it('filters contacts by user with scope', function () {
    $user = User::factory()->create();
    Contact::factory()->create(['user_id' => $user->id]);
    Contact::factory()->create(); // different user

    $contacts = Contact::forUser($user->id)->get();

    expect($contacts)->toHaveCount(1)
        ->and($contacts->first()->user_id)->toBe($user->id);
});
