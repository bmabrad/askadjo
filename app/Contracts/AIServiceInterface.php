<?php

namespace App\Contracts;

interface AIServiceInterface
{
    /**
     * Analyse a conversation and return coaching advice.
     *
     * @param  string|null  $text  The pasted conversation text
     * @param  array  $screenshots  Array of screenshot file paths
     * @param  string|null  $contactSummary  The AI's running summary for this contact
     * @return array{
     *   contact_name: ?string,
     *   contact_name_confidence: string,
     *   platform: ?string,
     *   situation_read: string,
     *   applicable_principles: array,
     *   reply_options: array<array{text: string, strategy: string, why: string}>,
     *   contact_summary_update: string,
     *   raw_response: string,
     *   prompt_tokens: int,
     *   completion_tokens: int
     * }
     */
    public function analyseConversation(
        ?string $text,
        array $screenshots = [],
        ?string $contactSummary = null
    ): array;
}
