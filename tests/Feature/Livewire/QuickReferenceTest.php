<?php

use App\Livewire\QuickReference;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the component', function () {
    Livewire::test(QuickReference::class)->assertOk();
});

it('loads the quick ref page for authenticated users', function () {
    $this->get('/quick-ref')->assertOk();
});

it('requires authentication', function () {
    auth()->logout();
    $this->get('/quick-ref')->assertRedirect(route('login'));
});

it('displays all eight card titles', function () {
    Livewire::test(QuickReference::class)
        ->assertSee('The One Rule')
        ->assertSee('The 4 Frames')
        ->assertSee('The 10 Triggers')
        ->assertSee('The Text Rules')
        ->assertSee('The Reframing Formula')
        ->assertSee('Emergency Reset')
        ->assertSee('The Compliment Rule')
        ->assertSee('Scarcity Reminders');
});

it('navigates cards forward with nextCard', function () {
    Livewire::test(QuickReference::class)
        ->assertSet('currentCard', 0)
        ->call('nextCard')
        ->assertSet('currentCard', 1)
        ->call('nextCard')
        ->assertSet('currentCard', 2);
});

it('navigates cards backward with prevCard', function () {
    Livewire::test(QuickReference::class)
        ->set('currentCard', 3)
        ->call('prevCard')
        ->assertSet('currentCard', 2);
});

it('stays at zero when calling prevCard at first card', function () {
    Livewire::test(QuickReference::class)
        ->assertSet('currentCard', 0)
        ->call('prevCard')
        ->assertSet('currentCard', 0);
});

it('stays at seven when calling nextCard at last card', function () {
    Livewire::test(QuickReference::class)
        ->set('currentCard', 7)
        ->call('nextCard')
        ->assertSet('currentCard', 7);
});

it('displays the intro text', function () {
    Livewire::test(QuickReference::class)
        ->assertSee('Swipe through. Glance in 5 seconds. Get back to the conversation.');
});
