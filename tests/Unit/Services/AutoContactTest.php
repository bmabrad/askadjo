<?php

use App\Contracts\AIServiceInterface;
use App\Models\Contact;
use App\Models\User;
use App\Services\CoachingService;
use App\Services\FakeAIService;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('includes contact_name in AI response', function () {
    $fake = new FakeAIService;
    $result = $fake->analyseConversation('Her: Hey\nMe: Hello');

    expect($result)->toHaveKey('contact_name')
        ->and($result)->toHaveKey('contact_name_confidence')
        ->and($result['contact_name'])->toBe('Sophie');
});

it('auto-creates contact on high confidence', function () {
    $fake = new FakeAIService;
    $service = new CoachingService($fake);

    $session = $service->coachWithAutoContact($this->user, 'Her: Hey\nMe: Hello');

    expect($session->contact)->not->toBeNull()
        ->and($session->contact->name)->toBe('Sophie')
        ->and($session->contact->user_id)->toBe($this->user->id);
});

it('matches existing contact on high confidence', function () {
    $existing = Contact::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Sophie',
    ]);

    $fake = new FakeAIService;
    $service = new CoachingService($fake);

    $session = $service->coachWithAutoContact($this->user, 'Her: Hey\nMe: Hello');

    expect($session->contact_id)->toBe($existing->id);
    // No duplicate created
    expect($this->user->contacts()->where('name', 'Sophie')->count())->toBe(1);
});

it('creates Unknown contact when no name confidence and no prior sessions', function () {
    $fake = new FakeAIService;
    $fake->setResponse([
        'contact_name' => null,
        'contact_name_confidence' => 'none',
        'platform' => null,
        'situation_read' => 'Test read',
        'applicable_principles' => ['Test'],
        'reply_options' => [
            ['label' => 'Recommended', 'text' => 'Test reply', 'strategy' => 'Direct', 'why' => 'Because.'],
        ],
        'contact_summary_update' => 'Test summary.',
        'raw_response' => '{"fake": true}',
        'prompt_tokens' => 100,
        'completion_tokens' => 50,
    ]);

    $service = new CoachingService($fake);
    $session = $service->coachWithAutoContact($this->user, 'Her: Hey\nMe: Hello');

    expect($session->contact->name)->toBe('Unknown');
});

it('falls back to most recent contact when no name and prior sessions exist', function () {
    // Create an existing contact with a prior session
    $existingContact = Contact::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Sophie',
    ]);
    $existingContact->coachingSessions()->create([
        'input_type' => \App\Enums\InputType::Text,
        'raw_text' => 'Prior conversation',
        'situation_read' => 'Prior read',
        'applicable_principles' => ['Test'],
        'reply_options' => [],
    ]);

    $fake = new FakeAIService;
    $fake->setResponse([
        'contact_name' => null,
        'contact_name_confidence' => 'none',
        'platform' => null,
        'situation_read' => 'New analysis',
        'applicable_principles' => ['Test'],
        'reply_options' => [],
        'contact_summary_update' => 'Follow-up summary.',
        'raw_response' => '{"fake": true}',
        'prompt_tokens' => 100,
        'completion_tokens' => 50,
    ]);

    $service = new CoachingService($fake);
    $session = $service->coachWithAutoContact($this->user, 'Follow-up conversation');

    expect($session->contact_id)->toBe($existingContact->id)
        ->and($session->contact->name)->toBe('Sophie');
});

it('writes contact summary update on auto-created contact', function () {
    $fake = new FakeAIService;
    $service = new CoachingService($fake);

    $session = $service->coachWithAutoContact($this->user, 'Her: Hey\nMe: Hello');

    expect($session->contact->fresh()->ai_summary)->not->toBeNull()
        ->and($session->contact->fresh()->ai_summary)->toContain('Sophie');
});
