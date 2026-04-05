<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('shows back arrow on all authenticated pages', function (string $route) {
    $this->get(route($route))
        ->assertOk()
        ->assertSee('Open menu', escape: false);
})->with(['strat-chat', 'mindset', 'playbook', 'quick-ref', 'settings']);

it('hides close button on strat chat page', function () {
    $this->get(route('strat-chat'))
        ->assertOk()
        ->assertDontSee('aria-label="Close"', escape: false);
});

it('shows close button on other pages', function (string $route) {
    $this->get(route($route))
        ->assertOk()
        ->assertSee('aria-label="Close"', escape: false);
})->with(['mindset', 'playbook', 'quick-ref', 'settings']);

it('close button links to strat chat', function () {
    $response = $this->get(route('mindset'));

    $response->assertOk()
        ->assertSee(route('strat-chat'), escape: false);
});

it('displays correct page title for each route', function (string $route, string $title) {
    $this->get(route($route))
        ->assertOk()
        ->assertSee($title);
})->with([
    ['strat-chat', 'Strat Chat'],
    ['mindset', 'The Mindset'],
    ['playbook', 'The Playbook'],
    ['quick-ref', 'Quick Reference'],
    ['settings', 'Settings'],
]);
