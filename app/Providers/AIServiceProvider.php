<?php

namespace App\Providers;

use App\Contracts\AIServiceInterface;
use App\Services\AIService;
use App\Services\FakeAIService;
use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AIServiceInterface::class, function ($app) {
            if ($app->environment('testing')) {
                return new FakeAIService();
            }

            return new AIService(
                apiKey: config('services.anthropic.api_key'),
                model: config('services.anthropic.model'),
            );
        });
    }
}
