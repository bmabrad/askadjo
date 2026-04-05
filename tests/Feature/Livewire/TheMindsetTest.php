<?php

use App\Livewire\TheMindset;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the component', function () {
    Livewire::test(TheMindset::class)->assertOk();
});

it('loads the mindset page for authenticated users', function () {
    $this->get('/mindset')->assertOk();
});

it('requires authentication', function () {
    auth()->logout();
    $this->get('/mindset')->assertRedirect(route('login'));
});

it('displays all section headings', function () {
    Livewire::test(TheMindset::class)
        ->assertSee('THE 4 FRAMES')
        ->assertSee('THE 10 TRIGGERS')
        ->assertSee('HOW SHE EXPERIENCES DATING')
        ->assertSee('THE 10 TEXT RULES')
        ->assertSee('REFRAMING')
        ->assertSee('EMERGENCY RESET');
});

it('displays the opening callout quote', function () {
    Livewire::test(TheMindset::class)
        ->assertSee('The goal is not for her to wonder if you like her');
});

it('displays all ten triggers', function () {
    Livewire::test(TheMindset::class)
        ->assertSee('Preselection')
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
    Livewire::test(TheMindset::class)
        ->assertSee('Statements over questions')
        ->assertSee('Drop the question mark')
        ->assertSee('Keep it short, 2 lines max')
        ->assertSee('Never reply instantly')
        ->assertSee('End convos first, at the peak')
        ->assertSee('Embed triggers subtly')
        ->assertSee('Create ambiguity')
        ->assertSee('Never profess feelings first')
        ->assertSee('No response? No ego.')
        ->assertSee('Check she');
});

it('displays the CTA linking to strat chat', function () {
    Livewire::test(TheMindset::class)
        ->assertSee('Now open Strat Chat')
        ->assertSeeHtml('href="' . route('strat-chat') . '"');
});
