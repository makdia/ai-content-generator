<?php

namespace App\Providers;

use App\Services\Contracts\ContentGenerator;
use App\Services\LocalContentGenerator;
use App\Services\OpenAIContentGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ContentGenerator::class, function () {
            $driver = env('AI_DRIVER', 'local');

            if ($driver === 'openai') {
                return new OpenAIContentGenerator();
            }

            return new LocalContentGenerator();
        });
    }

    public function boot(): void {}
}
