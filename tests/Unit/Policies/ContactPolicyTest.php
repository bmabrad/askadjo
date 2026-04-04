<?php

use App\Models\Contact;
use App\Models\User;
use App\Policies\ContactPolicy;

beforeEach(function () {
    $this->policy = new ContactPolicy();
    $this->owner = User::factory()->create();
    $this->other = User::factory()->create();
    $this->contact = Contact::factory()->create(['user_id' => $this->owner->id]);
});

it('allows owner to update contact', function () {
    expect($this->policy->update($this->owner, $this->contact))->toBeTrue();
});

it('denies other user from updating contact', function () {
    expect($this->policy->update($this->other, $this->contact))->toBeFalse();
});

it('allows owner to archive contact', function () {
    expect($this->policy->archive($this->owner, $this->contact))->toBeTrue();
});

it('denies other user from archiving contact', function () {
    expect($this->policy->archive($this->other, $this->contact))->toBeFalse();
});

it('allows owner to restore contact', function () {
    expect($this->policy->restore($this->owner, $this->contact))->toBeTrue();
});

it('denies other user from restoring contact', function () {
    expect($this->policy->restore($this->other, $this->contact))->toBeFalse();
});

it('allows owner to delete contact', function () {
    expect($this->policy->delete($this->owner, $this->contact))->toBeTrue();
});

it('denies other user from deleting contact', function () {
    expect($this->policy->delete($this->other, $this->contact))->toBeFalse();
});
