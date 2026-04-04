<?php

namespace Database\Factories;

use App\Enums\InputType;
use App\Models\CoachingSession;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoachingSession>
 */
class CoachingSessionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory(),
            'input_type' => InputType::Text,
            'raw_text' => 'Her: Hey how are you?\nMe: Good, you?\nHer: Great thanks!',
            'screenshot_path' => null,
            'situation_read' => 'She initiated but the conversation is flat. You\'re matching her energy instead of leading.',
            'applicable_principles' => ['Low Perceived Effort', 'Be a Challenge'],
            'reply_options' => [
                [
                    'label' => 'Recommended',
                    'text' => 'Doing better now. What trouble are you getting into this weekend?',
                    'strategy' => 'Playful',
                    'why' => 'Redirects to plans, creates opportunity to suggest a meetup.',
                ],
            ],
            'ai_raw_response' => '{"fake": true}',
            'prompt_tokens' => 1200,
            'completion_tokens' => 300,
        ];
    }

    public function screenshot(): static
    {
        return $this->state([
            'input_type' => InputType::Screenshot,
            'raw_text' => null,
            'screenshot_path' => ['screenshots/test-conversation.png'],
        ]);
    }

    public function pending(): static
    {
        return $this->state([
            'situation_read' => null,
            'applicable_principles' => null,
            'reply_options' => null,
            'ai_raw_response' => null,
            'prompt_tokens' => null,
            'completion_tokens' => null,
        ]);
    }
}
