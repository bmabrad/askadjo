<?php

use Illuminate\Support\Facades\Schema;

it('has the users table', function () {
    expect(Schema::hasTable('users'))->toBeTrue();
});

it('has the contacts table with correct columns', function () {
    expect(Schema::hasTable('contacts'))->toBeTrue()
        ->and(Schema::hasColumns('contacts', [
            'id', 'user_id', 'name', 'platform', 'status', 'notes',
            'created_at', 'updated_at',
        ]))->toBeTrue();
});

it('has the coaching_sessions table with correct columns', function () {
    expect(Schema::hasTable('coaching_sessions'))->toBeTrue()
        ->and(Schema::hasColumns('coaching_sessions', [
            'id', 'contact_id', 'input_type', 'raw_text', 'screenshot_path',
            'situation_read', 'applicable_principles', 'reply_options',
            'ai_raw_response', 'prompt_tokens', 'completion_tokens',
            'created_at', 'updated_at',
        ]))->toBeTrue();
});

it('has the personal_access_tokens table', function () {
    expect(Schema::hasTable('personal_access_tokens'))->toBeTrue();
});
