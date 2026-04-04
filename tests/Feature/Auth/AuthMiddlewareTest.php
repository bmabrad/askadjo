<?php

use App\Models\User;

it('redirects unauthenticated users to login', function () {
    $this->get('/coach')
        ->assertRedirect(route('login'));
});

it('allows authenticated users to access coach', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('coach'))
        ->assertStatus(200);
});
