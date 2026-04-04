<?php

use App\Services\CoachingPrompt;

it('contains key methodology principles', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('Evaluator Frame')
        ->toContain('Low Perceived Effort')
        ->toContain('Intermittent Positive Reinforcement')
        ->toContain('Curiosity Gaps')
        ->toContain('Frame Control')
        ->toContain('Embedded Triggers')
        ->toContain('The Master Rule');
});

it('requests JSON response format', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('JSON')
        ->toContain('situation_read')
        ->toContain('reply_options')
        ->toContain('applicable_principles');
});

it('includes conditional reply options guidance', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('When to Include Reply Options')
        ->toContain('Only include reply_options when the conversation is waiting for the user to respond')
        ->toContain('"reply_options": []');
});

it('includes screenshot reading rules', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('Screenshot Reading')
        ->toContain('RIGHT side of the screen')
        ->toContain('LEFT side of the screen');
});

it('includes contact summary instructions', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('Contact Summary')
        ->toContain('contact_summary_update')
        ->toContain('under 200 words');
});

it('includes situational message library', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('Situational Message Library')
        ->toContain('OPENING')
        ->toContain('BUILDING ATTRACTION');
});

it('builds user message with contact summary', function () {
    $summary = 'User double-texted Sophie. Advised scarcity. Frame shifted.';
    $message = CoachingPrompt::buildUserMessage('New conversation text', $summary);

    expect($message)
        ->toContain('## Contact Summary')
        ->toContain($summary)
        ->toContain('## Current Conversation')
        ->toContain('New conversation text');
});

it('builds user message without contact summary', function () {
    $message = CoachingPrompt::buildUserMessage('Just the conversation');

    expect($message)
        ->toBe('Just the conversation')
        ->not->toContain('Contact Summary');
});
