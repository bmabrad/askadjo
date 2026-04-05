<?php

use App\Services\AIService;
use Illuminate\Support\Facades\Http;

it('sends correct request format for text analysis', function () {
    Http::fake([
        'api.anthropic.com/*' => Http::response([
            'content' => [['type' => 'text', 'text' => json_encode([
                'situation_read' => 'Test read',
                'applicable_principles' => ['Test Principle'],
                'reply_options' => [
                    ['label' => 'Recommended', 'text' => 'Test reply', 'strategy' => 'Direct', 'why' => 'Because.'],
                ],
            ])]],
            'usage' => ['input_tokens' => 100, 'output_tokens' => 50],
        ]),
    ]);

    $service = new AIService('fake-key', 'claude-sonnet-4-20250514');
    $result = $service->analyseConversation('Her: Hey\nMe: Hello');

    expect($result['situation_read'])->toBe('Test read')
        ->and($result['reply_options'])->toHaveCount(1)
        ->and($result['prompt_tokens'])->toBe(100);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'api.anthropic.com')
            && $request->header('x-api-key')[0] === 'fake-key'
            && $request['model'] === 'claude-sonnet-4-20250514';
    });
});

it('includes image content blocks for screenshots', function () {
    Http::fake([
        'api.anthropic.com/*' => Http::response([
            'content' => [['type' => 'text', 'text' => json_encode([
                'situation_read' => 'Screenshot read',
                'applicable_principles' => ['Visual Analysis'],
                'reply_options' => [
                    ['label' => 'Recommended', 'text' => 'Reply', 'strategy' => 'Direct', 'why' => 'Why.'],
                ],
            ])]],
            'usage' => ['input_tokens' => 200, 'output_tokens' => 60],
        ]),
    ]);

    // Store a fake screenshot
    \Illuminate\Support\Facades\Storage::fake('screenshots');
    \Illuminate\Support\Facades\Storage::disk('screenshots')->put('test.jpg', 'fake-image-data');

    $service = new AIService('fake-key', 'claude-sonnet-4-20250514');
    $result = $service->analyseConversation(null, ['test.jpg']);

    expect($result['situation_read'])->toBe('Screenshot read');

    Http::assertSent(function ($request) {
        $content = $request['messages'][0]['content'];
        return collect($content)->contains(fn ($block) => ($block['type'] ?? '') === 'image');
    });
});

it('handles API error gracefully', function () {
    Http::fake([
        'api.anthropic.com/*' => Http::response(['error' => 'Internal Server Error'], 500),
    ]);

    $service = new AIService('fake-key', 'claude-sonnet-4-20250514');

    expect(fn () => $service->analyseConversation('Test'))
        ->toThrow(\RuntimeException::class);
});

it('sends system prompt with cache control', function () {
    Http::fake([
        'api.anthropic.com/*' => Http::response([
            'content' => [['type' => 'text', 'text' => json_encode([
                'situation_read' => 'Test',
                'applicable_principles' => [],
                'reply_options' => [],
            ])]],
            'usage' => ['input_tokens' => 100, 'output_tokens' => 50],
        ]),
    ]);

    $service = new AIService('fake-key', 'claude-sonnet-4-20250514');
    $service->analyseConversation('Test text');

    Http::assertSent(function ($request) {
        $system = $request['system'];

        // System must be an array (not a plain string)
        if (! is_array($system)) {
            return false;
        }

        // First element must have cache_control set to ephemeral
        return ($system[0]['type'] ?? '') === 'text'
            && ! empty($system[0]['text'])
            && ($system[0]['cache_control']['type'] ?? '') === 'ephemeral'
            && $request->header('anthropic-beta')[0] === 'prompt-caching-2024-07-31';
    });
});

it('logs cache token usage from API response', function () {
    Http::fake([
        'api.anthropic.com/*' => Http::response([
            'content' => [['type' => 'text', 'text' => json_encode([
                'situation_read' => 'Test',
                'applicable_principles' => [],
                'reply_options' => [],
            ])]],
            'usage' => [
                'input_tokens' => 100,
                'output_tokens' => 50,
                'cache_creation_input_tokens' => 15000,
                'cache_read_input_tokens' => 0,
            ],
        ]),
    ]);

    $service = new AIService('fake-key', 'claude-sonnet-4-20250514');
    $result = $service->analyseConversation('Test text');

    expect($result['cache_creation_input_tokens'])->toBe(15000)
        ->and($result['cache_read_input_tokens'])->toBe(0);
});

it('handles malformed JSON response', function () {
    Http::fake([
        'api.anthropic.com/*' => Http::response([
            'content' => [['type' => 'text', 'text' => 'This is not JSON']],
            'usage' => ['input_tokens' => 100, 'output_tokens' => 50],
        ]),
    ]);

    $service = new AIService('fake-key', 'claude-sonnet-4-20250514');

    expect(fn () => $service->analyseConversation('Test'))
        ->toThrow(\RuntimeException::class, 'Failed to parse AI response');
});
