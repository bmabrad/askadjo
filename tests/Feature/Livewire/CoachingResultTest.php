<?php

use App\Enums\InputType;
use App\Livewire\CoachingResult;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->contact = Contact::factory()->create(['user_id' => $this->user->id]);
});

it('renders with a completed session', function () {
    $session = CoachingSession::factory()->create(['contact_id' => $this->contact->id]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertOk()
        ->assertSee($session->situation_read);
});

it('displays all reply options with copy buttons', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'reply_options' => [
            ['label' => 'Recommended', 'text' => 'First reply', 'strategy' => 'Playful', 'why' => 'Because playful.'],
            ['label' => 'Alternative', 'text' => 'Second reply', 'strategy' => 'Direct', 'why' => 'Because direct.'],
            ['label' => 'Alternative', 'text' => 'Third reply', 'strategy' => 'Scarce', 'why' => 'Because scarce.'],
        ],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee('Try one of these:')
        ->assertSee('First reply')
        ->assertSee('Second reply')
        ->assertSee('Third reply')
        ->assertSee('Copy');
});

it('shows more section with principles on toggle', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'applicable_principles' => ['Intermittent Reinforcement', 'The Evaluator Frame'],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee('More')
        ->assertDontSee('The Evaluator Frame')
        ->call('toggleMore')
        ->assertSee('Intermittent Reinforcement')
        ->assertSee('The Evaluator Frame');
});

it('shows principle tags inline preview', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'applicable_principles' => ['Intermittent Reinforcement'],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee('intermittent_reinforcement');
});

it('toggles why expand and collapse inside more section', function () {
    $session = CoachingSession::factory()->create(['contact_id' => $this->contact->id]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertDontSee($session->reply_options[0]['why'])
        ->call('toggleMore')
        ->assertDontSee($session->reply_options[0]['why'])
        ->call('toggleWhy', 0)
        ->assertSee($session->reply_options[0]['why'])
        ->call('toggleWhy', 0)
        ->assertDontSee($session->reply_options[0]['why']);
});

it('shows strategy tag in why explanation', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'reply_options' => [
            ['label' => 'Recommended', 'text' => 'Test reply', 'strategy' => 'Scarce', 'why' => 'Pulls back without being reactive.'],
        ],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->call('toggleMore')
        ->call('toggleWhy', 0)
        ->assertSee('Scarce')
        ->assertSee('Pulls back without being reactive.');
});

it('renders gracefully with empty reply options', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'situation_read' => 'You sent the last message. Ball is in their court.',
        'reply_options' => [],
        'applicable_principles' => ['Low Perceived Effort'],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertOk()
        ->assertSee('You sent the last message. Ball is in their court.')
        ->assertDontSee('Try one of these:');
});

it('displays error state when AI failed', function () {
    $session = CoachingSession::factory()->pending()->create(['contact_id' => $this->contact->id]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee("Couldn't analyse that one", escape: false)
        ->assertSee('Try Again');
});
