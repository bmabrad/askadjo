<?php

use App\Livewire\StratChat;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders the component', function () {
    Livewire::test(StratChat::class)->assertOk();
});

it('shows welcome message for new user', function () {
    Livewire::test(StratChat::class)
        ->assertSee('Paste your first conversation to get started.');
});

it('displays all sessions chronologically', function () {
    $contact1 = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Sophie']);
    $contact2 = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Jess']);

    CoachingSession::factory()->create([
        'contact_id' => $contact1->id,
        'situation_read' => 'First session',
        'created_at' => now()->subDay(),
    ]);
    CoachingSession::factory()->create([
        'contact_id' => $contact2->id,
        'situation_read' => 'Second session',
        'created_at' => now(),
    ]);

    $component = Livewire::test(StratChat::class);

    $sessions = $component->get('sessions');
    expect($sessions)->toHaveCount(2)
        ->and($sessions->first()->contact->name)->toBe('Sophie')
        ->and($sessions->last()->contact->name)->toBe('Jess');
});

it('labels sessions with contact name', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Sophie']);
    CoachingSession::factory()->create(['contact_id' => $contact->id]);

    Livewire::test(StratChat::class)
        ->assertSee('Sophie');
});

it('shows name prompt when contact is Unknown', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Unknown']);
    CoachingSession::factory()->create(['contact_id' => $contact->id]);

    Livewire::test(StratChat::class)
        ->assertSee("Who's this conversation with?", escape: false);
});

it('creates contact when name is submitted', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Unknown']);
    $session = CoachingSession::factory()->create(['contact_id' => $contact->id]);

    Livewire::test(StratChat::class)
        ->set('nameInput', 'Sophie')
        ->call('submitName');

    expect($contact->fresh()->name)->toBe('Sophie');
});

it('matches existing contact when name is submitted', function () {
    $existing = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Sophie']);
    $unknown = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Unknown']);
    $session = CoachingSession::factory()->create(['contact_id' => $unknown->id]);

    // Manually set pendingNameSessionId since auto-detect requires count === 1
    $component = Livewire::test(StratChat::class)
        ->set('pendingNameSessionId', $session->id)
        ->set('nameInput', 'Sophie')
        ->call('submitName');

    expect($session->fresh()->contact_id)->toBe($existing->id);
    $this->assertDatabaseMissing('contacts', ['id' => $unknown->id]);
});

it('does not show name prompt for subsequent Unknown sessions', function () {
    $contact = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Sophie']);
    CoachingSession::factory()->create([
        'contact_id' => $contact->id,
        'created_at' => now()->subHour(),
    ]);

    $unknown = Contact::factory()->create(['user_id' => $this->user->id, 'name' => 'Unknown']);
    CoachingSession::factory()->create(['contact_id' => $unknown->id]);

    Livewire::test(StratChat::class)
        ->assertDontSee("Who's this conversation with?", escape: false);
});
