<?php

use App\Livewire\ThePlaybook;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the component', function () {
    Livewire::test(ThePlaybook::class)->assertOk();
});

it('loads the playbook page for authenticated users', function () {
    $this->get('/playbook')->assertOk();
});

it('requires authentication', function () {
    auth()->logout();
    $this->get('/playbook')->assertRedirect(route('login'));
});

it('displays all section headings', function () {
    Livewire::test(ThePlaybook::class)
        ->assertSee('THE ONE RULE')
        ->assertSee('THE 4 FRAMES')
        ->assertSee('THE 10 ATTRACTION TRIGGERS')
        ->assertSee('HOW SHE EXPERIENCES DATING')
        ->assertSee('THE TEXT RULES')
        ->assertSee('THE MOST IMPORTANT SKILL: REFRAMING')
        ->assertSee("YOU'RE READY", escape: false);
});

it('displays the opening callout quote', function () {
    Livewire::test(ThePlaybook::class)
        ->assertSee('The goal is not for her to wonder if you like her');
});

it('displays all four frame titles', function () {
    Livewire::test(ThePlaybook::class)
        ->assertSee('Frame 1: Be the evaluator')
        ->assertSee('Frame 2: Challenging beats nice')
        ->assertSee('Frame 3: Low visible effort')
        ->assertSee('Frame 4: No limiting beliefs');
});

it('displays all ten triggers with descriptions', function () {
    Livewire::test(ThePlaybook::class)
        ->assertSee('Preselection')
        ->assertSee('Other women are visibly interested in you')
        ->assertSee('Being a Challenge')
        ->assertSee('Confidence')
        ->assertSee('Status')
        ->assertSee('Social Intuition')
        ->assertSee('Leadership')
        ->assertSee('Humour')
        ->assertSee('Intelligence')
        ->assertSee('Fitness')
        ->assertSee('Money');
});

it('displays all ten text rules', function () {
    Livewire::test(ThePlaybook::class)
        ->assertSee('Statements over questions.')
        ->assertSee('Drop the question mark.')
        ->assertSee('Keep it short.')
        ->assertSee('Never reply instantly.')
        ->assertSee('End conversations first.')
        ->assertSee('Embed triggers subtly.')
        ->assertSee('Create ambiguity.')
        ->assertSee('Never profess feelings first.')
        ->assertSee('No response? No ego.')
        ->assertSee('Check she');
});

it('displays the reframing example', function () {
    Livewire::test(ThePlaybook::class)
        ->assertSee('I haven')
        ->assertSee('VALIDATE')
        ->assertSee('REDIRECT')
        ->assertSee('ANCHOR');
});

it('displays the CTA linking to strat chat', function () {
    Livewire::test(ThePlaybook::class)
        ->assertSee('get to work')
        ->assertSeeHtml('href="' . route('strat-chat') . '"');
});
