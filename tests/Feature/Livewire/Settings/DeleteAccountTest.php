<?php

use App\Livewire\Settings\DeleteAccount;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['password' => Hash::make('mypassword')]);
    $this->actingAs($this->user);
});

it('can delete account', function () {
    Livewire::test(DeleteAccount::class)
        ->call('confirmDeletion')
        ->set('password', 'mypassword')
        ->call('deleteAccount')
        ->assertRedirect(route('login'));

    $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
});

it('requires correct password to delete', function () {
    Livewire::test(DeleteAccount::class)
        ->call('confirmDeletion')
        ->set('password', 'wrongpassword')
        ->call('deleteAccount')
        ->assertHasErrors('password');

    $this->assertDatabaseHas('users', ['id' => $this->user->id]);
});

it('cascades deletion to contacts and sessions', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id]);
    $session = CoachingSession::factory()->create(['contact_id' => $contact->id]);

    Livewire::test(DeleteAccount::class)
        ->call('confirmDeletion')
        ->set('password', 'mypassword')
        ->call('deleteAccount');

    $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    $this->assertDatabaseMissing('coaching_sessions', ['id' => $session->id]);
});
