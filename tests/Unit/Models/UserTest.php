<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

it('has many contacts', function () {
    $user = User::factory()->create();

    expect($user->contacts)->toBeInstanceOf(Collection::class);
});

it('returns only related contacts', function () {
    $user = User::factory()->create();
    $contact = Contact::factory()->create(['user_id' => $user->id]);
    Contact::factory()->create(); // different user

    expect($user->contacts)->toHaveCount(1)
        ->and($user->contacts->first()->is($contact))->toBeTrue();
});
