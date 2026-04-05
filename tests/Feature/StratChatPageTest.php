<?php

use App\Models\User;

it('loads the strat-chat page for authenticated user', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('strat-chat'))
        ->assertOk();
});

it('requires authentication', function () {
    $this->get('/strat-chat')
        ->assertRedirect(route('login'));
});

it('redirects dashboard to strat-chat', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertRedirect(route('strat-chat'));
});
