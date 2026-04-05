<?php

namespace App\Services;

use App\Contracts\AIServiceInterface;
use App\Enums\InputType;
use App\Enums\Platform;
use App\Models\CoachingSession;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CoachingService
{
    public function __construct(
        protected AIServiceInterface $aiService,
    ) {}

    /**
     * Original method for backwards compatibility (contact thread, etc.)
     */
    public function coach(Contact $contact, ?string $text, array $screenshotPaths = []): CoachingSession
    {
        $inputType = ! empty($screenshotPaths) ? InputType::Screenshot : InputType::Text;

        $session = $contact->coachingSessions()->create([
            'input_type' => $inputType,
            'raw_text' => $text,
            'screenshot_path' => ! empty($screenshotPaths) ? $screenshotPaths : null,
        ]);

        try {
            $result = $this->aiService->analyseConversation($text, $screenshotPaths, $contact->ai_summary);

            $session->update([
                'situation_read' => $result['situation_read'],
                'applicable_principles' => $result['applicable_principles'],
                'reply_options' => $result['reply_options'],
                'ai_raw_response' => $result['raw_response'],
                'prompt_tokens' => $result['prompt_tokens'],
                'completion_tokens' => $result['completion_tokens'],
            ]);

            // Write the updated summary back to the contact
            if (! empty($result['contact_summary_update'])) {
                $contact->update(['ai_summary' => $result['contact_summary_update']]);
            }
        } catch (\Throwable $e) {
            Log::error('AI coaching failed', [
                'session_id' => $session->id,
                'error' => $e->getMessage(),
                'class' => get_class($e),
            ]);

            // Clean up the empty session
            $session->delete();

            throw $e;
        }

        return $session->fresh();
    }

    /**
     * New method for the single chat window — no contact required upfront.
     */
    public function coachWithAutoContact(User $user, ?string $text, array $screenshotPaths = []): CoachingSession
    {
        $inputType = ! empty($screenshotPaths) ? InputType::Screenshot : InputType::Text;

        // Pre-resolve contact for summary context (best effort)
        $recentContact = $this->getMostRecentContact($user);
        $contactSummary = $recentContact?->ai_summary;

        try {
            $result = $this->aiService->analyseConversation($text, $screenshotPaths, $contactSummary);

            $contact = $this->resolveContact($user, $result);

            $session = ($contact ?? $user->contacts()->create([
                'name' => 'Unknown',
                'platform' => Platform::Other,
            ]))->coachingSessions()->create([
                'input_type' => $inputType,
                'raw_text' => $text,
                'screenshot_path' => ! empty($screenshotPaths) ? $screenshotPaths : null,
                'situation_read' => $result['situation_read'],
                'applicable_principles' => $result['applicable_principles'],
                'reply_options' => $result['reply_options'],
                'ai_raw_response' => $result['raw_response'],
                'prompt_tokens' => $result['prompt_tokens'],
                'completion_tokens' => $result['completion_tokens'],
            ]);

            // Write the updated summary back to the resolved contact
            $resolvedContact = $session->contact;
            if (! empty($result['contact_summary_update'])) {
                $resolvedContact->update(['ai_summary' => $result['contact_summary_update']]);
            }

            return $session->fresh()->load('contact');
        } catch (\Throwable $e) {
            Log::error('AI coaching failed', [
                'error' => $e->getMessage(),
                'class' => get_class($e),
            ]);

            throw $e;
        }
    }

    /**
     * Resolve or create a contact based on AI response.
     */
    protected function resolveContact(User $user, array $result): ?Contact
    {
        $name = $result['contact_name'] ?? null;
        $confidence = $result['contact_name_confidence'] ?? 'none';

        if (! $name || $confidence === 'none') {
            // CHANGE-6: Fall back to the most recent session's contact instead of creating Unknown
            return $this->getMostRecentContact($user);
        }

        // high or low confidence — match or create
        $existing = $user->contacts()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->first();

        if ($existing) {
            return $existing;
        }

        $platform = $this->resolvePlatform($result['platform'] ?? null);

        return $user->contacts()->create([
            'name' => $name,
            'platform' => $platform,
        ]);
    }

    protected function resolvePlatform(?string $platformStr): Platform
    {
        if (! $platformStr) {
            return Platform::Other;
        }

        $map = [
            'tinder' => Platform::Tinder,
            'bumble' => Platform::Bumble,
            'hinge' => Platform::Hinge,
            'instagram' => Platform::Instagram,
            'imessage' => Platform::IMessage,
            'whatsapp' => Platform::WhatsApp,
        ];

        return $map[strtolower($platformStr)] ?? Platform::Other;
    }

    /**
     * Get the most recent contact the user has coached about.
     */
    protected function getMostRecentContact(User $user): ?Contact
    {
        $recentSession = CoachingSession::whereHas('contact', fn ($q) => $q->where('user_id', $user->id))
            ->orderByDesc('created_at')
            ->first();

        return $recentSession?->contact;
    }
}
