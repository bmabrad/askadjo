<?php

use App\Livewire\ContactThread;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->contact = Contact::factory()->create(['user_id' => $this->user->id]);
});

it('renders for the contact owner', function () {
    Livewire::test(ContactThread::class, ['contact' => $this->contact])
        ->assertOk()
        ->assertSee($this->contact->name);
});

it('denies access to non-owner', function () {
    $otherUser = User::factory()->create();
    $this->actingAs($otherUser);

    Livewire::test(ContactThread::class, ['contact' => $this->contact])
        ->assertForbidden();
});

it('displays coaching sessions in chronological order', function () {
    $first = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'situation_read' => 'First session read',
        'created_at' => now()->subDays(2),
    ]);
    $second = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'situation_read' => 'Second session read',
        'created_at' => now()->subDay(),
    ]);

    $component = Livewire::test(ContactThread::class, ['contact' => $this->contact]);

    $sessions = $component->get('sessions');
    expect($sessions->first()->id)->toBe($first->id)
        ->and($sessions->last()->id)->toBe($second->id);
});

it('displays date dividers between sessions on different days', function () {
    CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'created_at' => now()->subDays(2),
    ]);
    CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'created_at' => now(),
    ]);

    Livewire::test(ContactThread::class, ['contact' => $this->contact])
        ->assertSee('Today');
});

it('shows empty state for new contact', function () {
    Livewire::test(ContactThread::class, ['contact' => $this->contact])
        ->assertSee('No coaching sessions yet.');
});

it('has coach input with locked contact', function () {
    Livewire::test(ContactThread::class, ['contact' => $this->contact])
        ->assertSeeLivewire('coach-input');
});

it('refreshes after new session is created', function () {
    $component = Livewire::test(ContactThread::class, ['contact' => $this->contact]);

    expect($component->get('sessions'))->toHaveCount(0);

    CoachingSession::factory()->create(['contact_id' => $this->contact->id]);

    $component->dispatch('coaching-session-created', sessionId: 1);

    expect($component->get('sessions'))->toHaveCount(1);
});
