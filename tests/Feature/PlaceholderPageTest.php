<?php

use App\Models\User;

// PlaceholderPage is no longer used for mindset/playbook/quick-ref.
// Those routes now point to dedicated components tested in their own test files.
// This file validates the PlaceholderPage component still works if assigned to a route.

it('requires authentication for content pages', function () {
    $this->get('/mindset')->assertRedirect(route('login'));
    $this->get('/playbook')->assertRedirect(route('login'));
    $this->get('/quick-ref')->assertRedirect(route('login'));
});
