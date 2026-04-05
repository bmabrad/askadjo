<?php

use App\Models\User;

it('redirects guests to login', function () {
    $this->get('/')
        ->assertRedirect(route('login'));
});

it('redirects authenticated users to strat-chat', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/')
        ->assertRedirect(route('strat-chat'));
});
