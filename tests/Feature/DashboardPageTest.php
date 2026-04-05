<?php

use App\Models\User;

it('redirects unauthenticated dashboard to login', function () {
    $this->get('/dashboard')
        ->assertRedirect(route('login'));
});

it('redirects authenticated dashboard to strat-chat', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertRedirect(route('strat-chat'));
});

it('redirects to strat-chat after login', function () {
    $user = User::factory()->create(['password' => bcrypt('password123')]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password123',
    ])->assertRedirect(route('strat-chat'));
});
