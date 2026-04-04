<?php

use App\Models\User;

it('loads the settings page', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('settings'))
        ->assertOk();
});

it('requires authentication', function () {
    $this->get(route('settings'))
        ->assertRedirect(route('login'));
});
