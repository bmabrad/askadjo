<?php

use App\Models\User;

it('renders the registration screen', function () {
    $this->get(route('register'))->assertStatus(200);
});

it('allows new users to register', function () {
    $response = $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('onboarding'));
});

it('requires valid registration data', function () {
    $this->post(route('register'), [])
        ->assertSessionHasErrors(['name', 'email', 'password']);
});

it('requires a unique email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $this->post(route('register'), [
        'name' => 'Test',
        'email' => 'taken@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertSessionHasErrors('email');
});

it('requires password confirmation to match', function () {
    $this->post(route('register'), [
        'name' => 'Test',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different',
    ])->assertSessionHasErrors('password');
});
