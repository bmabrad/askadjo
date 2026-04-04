<?php

use App\Models\User;

it('shows the sales page for guests', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('AskAdjo')
        ->assertSee('Stop guessing.')
        ->assertSee('Create Your Account')
        ->assertSee('Log in');
});

it('redirects authenticated users to coach', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/')
        ->assertRedirect(route('coach'));
});

it('has links to register and login', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee(route('register'))
        ->assertSee(route('login'));
});

it('shows how it works section', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('How It Works')
        ->assertSee('Paste or screenshot your conversation')
        ->assertSee('Get a read on the situation')
        ->assertSee('Pick a reply and send it');
});

it('shows what you get section', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('What You Get')
        ->assertSee('Situation read')
        ->assertSee('Reply options')
        ->assertSee('The why behind each reply');
});
