<?php

namespace App\Livewire;

use App\Contracts\AIServiceInterface;
use App\Models\CoachingSession;
use Livewire\Component;

class CoachingResult extends Component
{
    public CoachingSession $session;
    public bool $showWhy = false;
    public bool $showOptions = false;
    public bool $loadingOption = false;

    public function mount(CoachingSession $session): void
    {
        $this->session = $session;
    }

    public function toggleWhy(): void
    {
        $this->showWhy = ! $this->showWhy;
    }

    public function toggleOptions(): void
    {
        // If we already have an alternative, just toggle visibility
        if (count($this->session->reply_options) > 1) {
            $this->showOptions = ! $this->showOptions;
            return;
        }

        // Generate an alternative via the AI service
        $this->loadingOption = true;

        try {
            $primary = $this->session->reply_options[0];
            $ai = app(AIServiceInterface::class);
            $alternative = $ai->generateAlternative(
                $this->session->situation_read,
                $primary['text']
            );

            $options = $this->session->reply_options;
            $options[] = $alternative;
            $this->session->update(['reply_options' => $options]);
            $this->session->refresh();

            $this->showOptions = true;
        } catch (\Throwable $e) {
            // Silently fail — button stays available for retry
        } finally {
            $this->loadingOption = false;
        }
    }

    public function render()
    {
        return view('livewire.coaching-result');
    }
}
