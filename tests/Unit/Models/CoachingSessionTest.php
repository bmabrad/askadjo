<?php

use App\Enums\InputType;
use App\Models\CoachingSession;
use App\Models\Contact;

it('belongs to a contact', function () {
    $session = CoachingSession::factory()->create();

    expect($session->contact)->toBeInstanceOf(Contact::class);
});

it('casts input_type to enum', function () {
    $session = CoachingSession::factory()->create(['input_type' => 'text']);

    expect($session->input_type)->toBeInstanceOf(InputType::class)
        ->and($session->input_type)->toBe(InputType::Text);
});

it('casts applicable_principles to array', function () {
    $principles = ['Intermittent Reinforcement', 'The Evaluator Frame'];
    $session = CoachingSession::factory()->create(['applicable_principles' => $principles]);

    $session->refresh();

    expect($session->applicable_principles)->toBeArray()
        ->and($session->applicable_principles)->toBe($principles);
});

it('casts reply_options to array', function () {
    $options = [
        ['label' => 'Recommended', 'text' => 'Test reply', 'strategy' => 'Scarce', 'why' => 'Because.'],
    ];
    $session = CoachingSession::factory()->create(['reply_options' => $options]);

    $session->refresh();

    expect($session->reply_options)->toBeArray()
        ->and($session->reply_options[0]['label'])->toBe('Recommended');
});
