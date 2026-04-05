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

it('renders the read card with situation text', function () {
    $session = CoachingSession::factory()->create(['contact_id' => $this->contact->id]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertOk()
        ->assertSee('THE READ')
        ->assertSee($session->situation_read);
});

it('renders send this card with recommended reply', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'reply_options' => [
            ['label' => 'Recommended', 'text' => 'Hey, sounds fun', 'strategy' => 'Playful', 'why' => 'Keeps it light.'],
        ],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee('SEND THIS')
        ->assertSee('Hey, sounds fun')
        ->assertSee('Copy');
});

it('renders why this works card', function () {
    $session = CoachingSession::factory()->create(['contact_id' => $this->contact->id]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee('WHY THIS WORKS');
});

it('expands why this works on toggle', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'reply_options' => [
            ['label' => 'Recommended', 'text' => 'Test reply', 'strategy' => 'Scarce', 'why' => 'Pulls back without being reactive.'],
        ],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertDontSee('Pulls back without being reactive.')
        ->call('toggleWhy')
        ->assertSee('Pulls back without being reactive.')
        ->assertSee('Scarce')
        ->call('toggleWhy')
        ->assertDontSee('Pulls back without being reactive.');
});

it('shows alternative replies when more options toggled', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'reply_options' => [
            ['label' => 'Recommended', 'text' => 'First reply', 'strategy' => 'Playful', 'why' => 'Because playful.'],
            ['label' => 'Alternative', 'text' => 'Second reply', 'strategy' => 'Direct', 'why' => 'Because direct.'],
            ['label' => 'Alternative', 'text' => 'Third reply', 'strategy' => 'Scarce', 'why' => 'Because scarce.'],
        ],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee('First reply')
        ->assertDontSee('Second reply')
        ->assertDontSee('Third reply')
        ->assertSee('More Options')
        ->call('toggleOptions')
        ->assertSee('Second reply')
        ->assertSee('Third reply')
        ->assertSee('OPTION 2')
        ->assertSee('OPTION 3');
});

it('renders principles inside the read card', function () {
    $session = CoachingSession::factory()->create([
        'contact_id' => $this->contact->id,
        'applicable_principles' => ['Intermittent Reinforcement', 'The Evaluator Frame'],
    ]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee('THE READ')
        ->assertSee('Intermittent Reinforcement')
        ->assertSee('The Evaluator Frame');
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
        ->assertDontSee('SEND THIS');
});

it('displays error state when AI failed', function () {
    $session = CoachingSession::factory()->pending()->create(['contact_id' => $this->contact->id]);

    Livewire::test(CoachingResult::class, ['session' => $session])
        ->assertSee("Couldn't analyse that one", escape: false)
        ->assertSee('Try Again');
});
