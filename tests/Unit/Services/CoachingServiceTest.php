<?php

use App\Contracts\AIServiceInterface;
use App\Enums\InputType;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Services\CoachingService;
use App\Services\FakeAIService;

beforeEach(function () {
    $this->fakeAI = new FakeAIService();
    $this->service = new CoachingService($this->fakeAI);
    $this->contact = Contact::factory()->create();
});

it('creates a session for text input', function () {
    $session = $this->service->coach($this->contact, 'Her: Hey\nMe: Hi');

    expect($session)->toBeInstanceOf(CoachingSession::class)
        ->and($session->input_type)->toBe(InputType::Text)
        ->and($session->raw_text)->toBe('Her: Hey\nMe: Hi');
});

it('creates a session for screenshot input', function () {
    $session = $this->service->coach($this->contact, null, ['screenshots/test.jpg']);

    expect($session->input_type)->toBe(InputType::Screenshot)
        ->and($session->screenshot_path)->toBe(['screenshots/test.jpg']);
});

it('populates AI response fields', function () {
    $session = $this->service->coach($this->contact, 'Test conversation');

    expect($session->situation_read)->not->toBeNull()
        ->and($session->applicable_principles)->toBeArray()->not->toBeEmpty()
        ->and($session->reply_options)->toBeArray()->not->toBeEmpty()
        ->and($session->prompt_tokens)->toBeGreaterThan(0);
});

it('passes contact summary to AI service', function () {
    $this->contact->update(['ai_summary' => 'Sophie pulled back. Advised scarcity.']);

    $spyAI = new class extends FakeAIService {
        public ?string $receivedSummary = null;

        public function analyseConversation(?string $text, array $screenshots = [], ?string $contactSummary = null): array
        {
            $this->receivedSummary = $contactSummary;
            return parent::analyseConversation($text, $screenshots, $contactSummary);
        }
    };

    $service = new CoachingService($spyAI);
    $service->coach($this->contact, 'New message');

    expect($spyAI->receivedSummary)->toBe('Sophie pulled back. Advised scarcity.');
});

it('writes contact summary update back to contact', function () {
    $session = $this->service->coach($this->contact, 'Test conversation');

    expect($this->contact->fresh()->ai_summary)->not->toBeNull()
        ->and($this->contact->fresh()->ai_summary)->toContain('Sophie');
});

it('rethrows AI failure so caller can handle it', function () {
    $failingAI = new class implements AIServiceInterface {
        public function analyseConversation(?string $text, array $screenshots = [], ?string $contactSummary = null): array
        {
            throw new \RuntimeException('API error');
        }
    };

    $service = new CoachingService($failingAI);

    expect(fn () => $service->coach($this->contact, 'Test'))
        ->toThrow(\RuntimeException::class, 'API error');

    // Ensure no orphan session was left behind
    expect($this->contact->coachingSessions()->count())->toBe(0);
});
