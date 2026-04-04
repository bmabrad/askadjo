<?php

use App\Models\User;

it('loads the coach page for authenticated user', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('coach'))
        ->assertOk();
});

it('requires authentication', function () {
    $this->get('/coach')
        ->assertRedirect(route('login'));
});

it('redirects dashboard to coach', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertRedirect(route('coach'));
});
