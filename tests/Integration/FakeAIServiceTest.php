<?php

use App\Contracts\AIServiceInterface;
use App\Services\FakeAIService;

it('returns a correctly structured response', function () {
    $fake = new FakeAIService();
    $response = $fake->analyseConversation('Test conversation');

    expect($response)
        ->toHaveKeys(['situation_read', 'applicable_principles', 'reply_options', 'contact_summary_update', 'raw_response', 'prompt_tokens', 'completion_tokens'])
        ->and($response['situation_read'])->toBeString()->not->toBeEmpty()
        ->and($response['applicable_principles'])->toBeArray()->not->toBeEmpty()
        ->and($response['reply_options'])->toBeArray()->not->toBeEmpty()
        ->and($response['reply_options'][0])->toHaveKeys(['label', 'text', 'strategy', 'why']);
});

it('allows setting a custom response', function () {
    $fake = new FakeAIService();
    $custom = [
        'situation_read' => 'Custom read',
        'applicable_principles' => ['Custom Principle'],
        'reply_options' => [
            ['label' => 'Test', 'text' => 'Custom reply', 'strategy' => 'Direct', 'why' => 'Testing.'],
        ],
        'raw_response' => '{"custom": true}',
        'prompt_tokens' => 100,
        'completion_tokens' => 50,
    ];

    $fake->setResponse($custom);

    expect($fake->analyseConversation('Any text'))
        ->situation_read->toBe('Custom read')
        ->and($fake->analyseConversation('Any text')['reply_options'][0]['text'])->toBe('Custom reply');
});

it('binds FakeAIService in testing environment', function () {
    $service = app(AIServiceInterface::class);

    expect($service)->toBeInstanceOf(FakeAIService::class);
});
