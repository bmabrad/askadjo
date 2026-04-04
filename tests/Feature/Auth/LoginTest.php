<?php

use App\Models\User;

it('renders the login screen', function () {
    $this->get(route('login'))->assertStatus(200);
});

it('allows users to log in with valid credentials', function () {
    $user = User::factory()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('coach'));
});

it('rejects invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

it('rejects nonexistent email', function () {
    $this->post(route('login'), [
        'email' => 'nobody@example.com',
        'password' => 'password',
    ]);

    $this->assertGuest();
});
