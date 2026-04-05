<?php

use App\Models\User;

it('redirects unauthenticated users to login', function () {
    $this->get('/strat-chat')
        ->assertRedirect(route('login'));
});

it('allows authenticated users to access strat-chat', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('strat-chat'))
        ->assertStatus(200);
});
