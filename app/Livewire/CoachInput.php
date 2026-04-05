<?php

namespace App\Livewire;

use App\Enums\Platform;
use App\Models\Contact;
use App\Services\CoachingService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CoachInput extends Component
{
    use WithFileUploads;

    public ?int $contactId = null;
    public string $inputMode = 'screenshot';
    public array $screenshots = [];
    public string $textInput = '';
    public bool $isSubmitting = false;
    public ?string $error = null;
    public bool $contactLocked = false;
    public bool $chatMode = false;

    // For inline contact creation
    public string $newContactName = '';
    public string $newContactPlatform = '';

    public function mount(?int $contactId = null, bool $chatMode = false): void
    {
        $this->chatMode = $chatMode;

        if ($contactId) {
            $this->contactId = $contactId;
            $this->contactLocked = true;
        }
    }

    public function updatedScreenshots(): void
    {
        $this->validateOnly('screenshots.*');
    }

    public function removeScreenshot(int $index): void
    {
        unset($this->screenshots[$index]);
        $this->screenshots = array_values($this->screenshots);
    }

    public function switchMode(string $mode): void
    {
        $this->inputMode = $mode;
        $this->error = null;
    }

    public function selectContact(int $contactId): void
    {
        $contact = Contact::where('id', $contactId)
            ->where('user_id', auth()->id())
            ->first();

        if ($contact) {
            $this->contactId = $contact->id;
        }
    }

    public function clearContact(): void
    {
        if (! $this->contactLocked) {
            $this->contactId = null;
        }
    }

    public function createContact(): void
    {
        $this->validate([
            'newContactName' => ['required', 'string', 'max:255'],
            'newContactPlatform' => ['required', 'string', \Illuminate\Validation\Rule::enum(Platform::class)],
        ]);

        $contact = auth()->user()->contacts()->create([
            'name' => $this->newContactName,
            'platform' => $this->newContactPlatform,
        ]);

        $this->contactId = $contact->id;
        $this->newContactName = '';
        $this->newContactPlatform = '';
    }

    public function submit(): void
    {
        $this->error = null;

        // Auto-detect input mode based on content
        $hasScreenshots = count($this->screenshots) > 0;
        $hasText = trim($this->textInput) !== '';

        if (! $hasScreenshots && ! $hasText) {
            $this->addError('textInput', 'Paste a conversation or upload a screenshot.');
            return;
        }

        $rules = [];

        if (! $this->chatMode) {
            $rules['contactId'] = ['required', 'exists:contacts,id'];
        }

        if ($hasScreenshots) {
            $rules['screenshots'] = ['array', 'min:1', 'max:4'];
            $rules['screenshots.*'] = ['image', 'max:5120', 'mimes:jpg,jpeg,png,webp'];
        }

        if ($hasText) {
            $rules['textInput'] = ['string', 'max:10000'];
        }

        $this->validate($rules);

        $this->isSubmitting = true;

        // Fail fast if API key is not configured
        if (empty(config('services.anthropic.api_key'))) {
            $this->error = "AI service is not configured. Please check the API key.";
            $this->isSubmitting = false;
            $this->js("window.dispatchEvent(new CustomEvent('coaching-failed'))");
            return;
        }

        try {
            $screenshotPaths = [];

            if ($hasScreenshots) {
                foreach ($this->screenshots as $file) {
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('', $filename, config('filesystems.screenshots'));
                    $screenshotPaths[] = $filename;
                }
            }

            $text = $hasText ? $this->textInput : null;
            $coachingService = app(CoachingService::class);

            if ($this->chatMode) {
                $session = $coachingService->coachWithAutoContact(auth()->user(), $text, $screenshotPaths);
            } else {
                $contact = Contact::where('id', $this->contactId)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
                $session = $coachingService->coach($contact, $text, $screenshotPaths);
            }

            $this->dispatch('coaching-session-created', sessionId: $session->id);

            // Clear inputs
            $this->screenshots = [];
            $this->textInput = '';
            $this->error = null;

            // Auto-focus input after response
            $this->dispatch('coach-response-received');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('CoachInput catch block hit', [
                'message' => $e->getMessage(),
                'class' => get_class($e),
            ]);

            if ($e->getMessage() === 'SERVICE_CREDITS_EXHAUSTED') {
                $this->error = "Our AI service is temporarily unavailable. Please try again in a few minutes.";
            } else {
                $this->error = "Something went wrong. Please try again in a few minutes.";
            }

            $this->js("window.dispatchEvent(new CustomEvent('coaching-failed'))");
        } finally {
            $this->isSubmitting = false;
        }
    }

    protected function rules(): array
    {
        return [
            'screenshots.*' => ['image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
        ];
    }

    public function render()
    {
        $contacts = $this->chatMode
            ? collect()
            : auth()->user()->contacts()->active()->orderBy('name')->get();

        return view('livewire.coach-input', [
            'contacts' => $contacts,
            'platforms' => Platform::cases(),
        ]);
    }
}
