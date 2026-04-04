<?php

namespace App\Services;

use App\Contracts\AIServiceInterface;

class FakeAIService implements AIServiceInterface
{
    private ?array $response = null;

    public function setResponse(array $response): void
    {
        $this->response = $response;
    }

    public function analyseConversation(
        ?string $text,
        array $screenshots = [],
        ?string $contactSummary = null
    ): array {
        if ($this->response !== null) {
            return $this->response;
        }

        return [
            'contact_name' => 'Sophie',
            'contact_name_confidence' => 'high',
            'platform' => null,
            'situation_read' => 'They\'re pulling back to test your investment level. You sent two messages in a row, which shifted the frame. They\'ve got the power right now.',
            'applicable_principles' => ['Intermittent Reinforcement', 'The Evaluator Frame'],
            'reply_options' => [
                [
                    'label' => 'Recommended',
                    'text' => 'Haha fair enough. Catch up later this week if you\'re around',
                    'strategy' => 'Scarce',
                    'why' => 'Pulls back without being reactive. Shows you have options and aren\'t waiting around. The casual tone resets the frame.',
                ],
                [
                    'label' => 'Alternative',
                    'text' => 'Bold move leaving me on read. Respect.',
                    'strategy' => 'Playful',
                    'why' => 'Acknowledges the dynamic without being butthurt about it. Humour signals confidence and flips the script.',
                ],
                [
                    'label' => 'Alternative',
                    'text' => 'Let me know when you\'re free. No stress.',
                    'strategy' => 'Direct',
                    'why' => 'Low effort, low investment. Puts the ball in their court without chasing. Works if you want to keep it simple.',
                ],
            ],
            'contact_summary_update' => 'User double-texted Sophie, she pulled back. Advised to pull back with scarcity. Frame shifted to her having power. Key dynamic: user tends to over-invest. Watch for re-engagement.',
            'raw_response' => '{"fake": true}',
            'prompt_tokens' => 1500,
            'completion_tokens' => 350,
        ];
    }
}
