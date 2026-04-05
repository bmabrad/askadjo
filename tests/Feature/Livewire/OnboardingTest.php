<?php

use App\Livewire\Onboarding;
use App\Models\User;
use Livewire\Livewire;

it('loads the onboarding page for new users', function () {
    $user = User::factory()->create(['has_seen_onboarding' => false]);
    $this->actingAs($user);

    $this->get('/onboarding')->assertOk();
});

it('redirects completed users to strat chat', function () {
    $user = User::factory()->create(['has_seen_onboarding' => true]);
    $this->actingAs($user);

    $this->get('/onboarding')->assertRedirect(route('strat-chat'));
});

it('requires authentication', function () {
    $this->get('/onboarding')->assertRedirect(route('login'));
});

it('renders the component for new users', function () {
    $user = User::factory()->create(['has_seen_onboarding' => false]);
    $this->actingAs($user);

    Livewire::test(Onboarding::class)->assertOk();
});

it('displays three steps', function () {
    $user = User::factory()->create(['has_seen_onboarding' => false]);
    $this->actingAs($user);

    Livewire::test(Onboarding::class)
        ->assertSee('Drop Your Conversation In')
        ->assertSee('Get Strategic Feedback')
        ->assertSee('Chat, Copy and Send');
});

it('displays the CTA button', function () {
    $user = User::factory()->create(['has_seen_onboarding' => false]);
    $this->actingAs($user);

    Livewire::test(Onboarding::class)
        ->assertSee("Let's Go", escape: false);
});

it('sets the flag and redirects on complete', function () {
    $user = User::factory()->create(['has_seen_onboarding' => false]);
    $this->actingAs($user);

    Livewire::test(Onboarding::class)
        ->call('complete')
        ->assertRedirect(route('strat-chat'));

    expect($user->fresh()->has_seen_onboarding)->toBeTrue();
});

it('redirects on mount if already seen', function () {
    $user = User::factory()->create(['has_seen_onboarding' => true]);
    $this->actingAs($user);

    Livewire::test(Onboarding::class)
        ->assertRedirect(route('strat-chat'));
});

it('has the has_seen_onboarding column', function () {
    $user = User::factory()->create();
    expect($user->fresh()->has_seen_onboarding)->toBeFalse();
});

it('registration redirects to onboarding', function () {
    $response = $this->post(route('register'), [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('onboarding'));
});

it('login skips onboarding for returning users', function () {
    $user = User::factory()->create([
        'has_seen_onboarding' => true,
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('strat-chat'));
});
