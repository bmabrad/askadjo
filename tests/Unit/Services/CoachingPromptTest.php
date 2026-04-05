<?php

use App\Services\CoachingPrompt;

it('contains key methodology principles', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('The Master Rule')
        ->toContain('Low Perceived Effort')
        ->toContain('Discerning Man')
        ->toContain('12 Triggers Ranked')
        ->toContain('7 Chase Mechanisms')
        ->toContain('Text Game (21 Rules)')
        ->toContain('Reframing')
        ->toContain('Relationship Power')
        ->toContain('Emergency Reset Questions');
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

it('includes the full playbook as Part 2', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('PART 2: THE FULL PLAYBOOK')
        ->toContain('PHASE 1: THE 4 MINDSET SHIFTS')
        ->toContain('THE 7 CHASE MECHANISMS')
        ->toContain('TEXT GAME: THE 21 RULES')
        ->toContain('EMERGENCY RESET QUESTIONS');
});

it('includes the situational library as Part 3', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('PART 3: SITUATIONAL MESSAGE LIBRARY')
        ->toContain('Situational Message Library')
        ->toContain('OPENING')
        ->toContain('BUILDING ATTRACTION')
        ->toContain('HANDLING HER QUESTIONS');
});

it('contains all three parts concatenated', function () {
    $prompt = CoachingPrompt::system();

    expect($prompt)
        ->toContain('PART 2: THE FULL PLAYBOOK')
        ->toContain('PART 3: SITUATIONAL MESSAGE LIBRARY');

    // Verify ordering: Part 2 comes before Part 3
    $part2Pos = strpos($prompt, 'PART 2: THE FULL PLAYBOOK');
    $part3Pos = strpos($prompt, 'PART 3: SITUATIONAL MESSAGE LIBRARY');
    expect($part2Pos)->toBeLessThan($part3Pos);
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
