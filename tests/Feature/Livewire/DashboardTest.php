<?php

use App\Enums\ContactStatus;
use App\Livewire\Dashboard;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders the dashboard', function () {
    Livewire::test(Dashboard::class)->assertOk();
});

it('displays user contacts', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Sarah']);

    Livewire::test(Dashboard::class)->assertSee('Sarah');
});

it('does not display other users contacts', function () {
    $other = User::factory()->create();
    Contact::factory()->create(['user_id' => $other->id, 'name' => 'OtherPerson']);

    Livewire::test(Dashboard::class)->assertDontSee('OtherPerson');
});

it('orders contacts by latest activity', function () {
    $older = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'OlderContact']);
    CoachingSession::factory()->create(['contact_id' => $older->id, 'created_at' => now()->subDays(2)]);

    $newer = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'NewerContact']);
    CoachingSession::factory()->create(['contact_id' => $newer->id, 'created_at' => now()]);

    $html = Livewire::test(Dashboard::class)->html();

    $newerPos = strpos($html, 'NewerContact');
    $olderPos = strpos($html, 'OlderContact');
    expect($newerPos)->toBeLessThan($olderPos);
});

it('shows no coaching yet for contacts without sessions', function () {
    Contact::factory()->create(['user_id' => $this->user->id]);

    Livewire::test(Dashboard::class)->assertSee('No coaching yet');
});

it('filters contacts by search', function () {
    Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Sarah']);
    Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Emma']);

    Livewire::test(Dashboard::class)
        ->set('search', 'Sarah')
        ->assertSee('Sarah')
        ->assertDontSee('Emma');
});

it('shows no results message for empty search', function () {
    Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Sarah']);

    Livewire::test(Dashboard::class)
        ->set('search', 'zzzzz')
        ->assertSee("No contacts matching", escape: false);
});

it('shows empty state for new user', function () {
    Livewire::test(Dashboard::class)
        ->assertSee('Welcome to Collaborate.ai')
        ->assertSee('Start Your First Session');
});

it('hides archived contacts', function () {
    Contact::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'ArchivedPerson',
        'status' => ContactStatus::Archived,
    ]);

    Livewire::test(Dashboard::class)->assertDontSee('ArchivedPerson');
});
