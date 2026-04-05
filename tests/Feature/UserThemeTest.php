<?php

use App\Models\User;

it('defaults theme to dark for new users', function () {
    $user = User::factory()->create();

    expect($user->fresh()->theme)->toBe('dark');
});

it('stores theme preference on user', function () {
    $user = User::factory()->create();

    $user->update(['theme' => 'light']);

    expect($user->fresh()->theme)->toBe('light');
});

it('has theme column in users table', function () {
    expect(Schema::hasColumn('users', 'theme'))->toBeTrue();
});
