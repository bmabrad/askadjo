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
