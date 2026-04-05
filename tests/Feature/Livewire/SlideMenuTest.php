<?php

use App\Livewire\SlideMenu;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders the component', function () {
    Livewire::test(SlideMenu::class)->assertOk();
});

it('starts closed', function () {
    Livewire::test(SlideMenu::class)
        ->assertSet('open', false);
});

it('opens when toggle is called', function () {
    Livewire::test(SlideMenu::class)
        ->call('toggle')
        ->assertSet('open', true);
});

it('closes when close is called', function () {
    Livewire::test(SlideMenu::class)
        ->call('toggle')
        ->call('close')
        ->assertSet('open', false);
});

it('displays four menu items', function () {
    Livewire::test(SlideMenu::class)
        ->assertSee('Strat Chat')
        ->assertSee('The Mindset')
        ->assertSee('The Playbook')
        ->assertSee('Quick Reference');
});

it('displays V2 coming soon items', function () {
    Livewire::test(SlideMenu::class)
        ->assertSee('Coming in V2')
        ->assertSee('Example Messages')
        ->assertSee('Profile Photos');
});

it('strat chat links correctly', function () {
    Livewire::test(SlideMenu::class)
        ->assertSee(route('strat-chat'));
});

it('shows user name and plan badge', function () {
    Livewire::test(SlideMenu::class)
        ->assertSee($this->user->name)
        ->assertSee('FREE');
});

it('toggles theme from dark to light', function () {
    Livewire::test(SlideMenu::class)
        ->assertSet('currentTheme', 'dark')
        ->call('toggleTheme')
        ->assertSet('currentTheme', 'light');
});

it('toggles theme from light to dark', function () {
    $this->user->update(['theme' => 'light']);

    Livewire::test(SlideMenu::class)
        ->assertSet('currentTheme', 'light')
        ->call('toggleTheme')
        ->assertSet('currentTheme', 'dark');
});

it('persists theme to database', function () {
    Livewire::test(SlideMenu::class)
        ->call('toggleTheme');

    expect($this->user->fresh()->theme)->toBe('light');
});

it('dispatches theme-changed browser event', function () {
    Livewire::test(SlideMenu::class)
        ->call('toggleTheme')
        ->assertDispatched('theme-changed');
});
