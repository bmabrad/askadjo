<?php

namespace App\Services;

use App\Contracts\AIServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AIService implements AIServiceInterface
{
    public function __construct(
        protected string $apiKey,
        protected string $model,
    ) {}

    public function analyseConversation(
        ?string $text,
        array $screenshots = [],
        ?string $contactSummary = null
    ): array {
        $content = $this->buildContent($text, $screenshots, $contactSummary);

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'anthropic-version' => '2023-06-01',
        ])->timeout((int) config('services.anthropic.timeout', 60))->post('https://api.anthropic.com/v1/messages', [
            'model' => $this->model,
            'max_tokens' => 1024,
            'system' => CoachingPrompt::system(),
            'messages' => [
                ['role' => 'user', 'content' => $content],
            ],
        ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Claude API request failed: ' . $response->status() . ' ' . $response->body()
            );
        }

        $body = $response->json();
        $rawText = $body['content'][0]['text'] ?? '';
        $parsed = $this->parseResponse($rawText);

        return [
            'contact_name' => $parsed['contact_name'] ?? null,
            'contact_name_confidence' => $parsed['contact_name_confidence'] ?? 'none',
            'platform' => $parsed['platform'] ?? null,
            'situation_read' => $parsed['situation_read'] ?? '',
            'applicable_principles' => $parsed['applicable_principles'] ?? [],
            'reply_options' => $parsed['reply_options'] ?? [],
            'contact_summary_update' => $parsed['contact_summary_update'] ?? '',
            'raw_response' => $rawText,
            'prompt_tokens' => $body['usage']['input_tokens'] ?? 0,
            'completion_tokens' => $body['usage']['output_tokens'] ?? 0,
        ];
    }

    protected function buildContent(?string $text, array $screenshots, ?string $contactSummary): array
    {
        $content = [];

        if (! empty($screenshots)) {
            foreach ($screenshots as $path) {
                $fileContents = Storage::disk(config('filesystems.screenshots'))->get($path);
                if ($fileContents) {
                    $base64 = base64_encode($fileContents);
                    $mimeType = $this->guessMimeType($path);
                    $content[] = [
                        'type' => 'image',
                        'source' => [
                            'type' => 'base64',
                            'media_type' => $mimeType,
                            'data' => $base64,
                        ],
                    ];
                }
            }
        }

        $userMessage = CoachingPrompt::buildUserMessage($text, $contactSummary);
        if ($userMessage) {
            $content[] = ['type' => 'text', 'text' => $userMessage];
        }

        if (empty($content)) {
            $content[] = ['type' => 'text', 'text' => 'Analyse this conversation.'];
        }

        return $content;
    }

    protected function parseResponse(string $rawText): array
    {
        $cleaned = trim($rawText);

        if (str_starts_with($cleaned, '```')) {
            $cleaned = preg_replace('/^```(?:json)?\s*/', '', $cleaned);
            $cleaned = preg_replace('/\s*```$/', '', $cleaned);
        }

        $parsed = json_decode($cleaned, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to parse AI response as JSON: ' . json_last_error_msg());
        }

        return $parsed;
    }

    protected function guessMimeType(string $path): string
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($ext) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };
    }
}
