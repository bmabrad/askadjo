<?php

use Illuminate\Support\Facades\RateLimiter;

it('has the coaching rate limiter defined', function () {
    expect(RateLimiter::limiter('coaching'))->not->toBeNull();
});
