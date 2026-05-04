<?php

namespace App\Providers;

use App\Models\Score;
use App\Observers\ScoreObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Services\AI\AiAdapterInterface::class, \App\Services\AI\DummyAiAdapter::class);
    }

    public function boot(): void
    {
        Score::observe(ScoreObserver::class);
    }
}
