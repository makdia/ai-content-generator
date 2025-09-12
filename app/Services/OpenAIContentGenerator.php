<?php

namespace App\Services;

use App\Services\Contracts\ContentGenerator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenAIContentGenerator implements ContentGenerator
{
    public function generate(string $prompt, array $options = []): array
    {
        $key   = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4o-mini');

        // Basic prompt shaping
        $tone     = $options['tone'] ?? 'neutral';
        $language = $options['language'] ?? 'en';
        $words    = $options['words'] ?? 300;

        $sys = "You are a professional content writer. Tone: {$tone}. Language: {$language}. Target length ~{$words} words. Be helpful, clear, and original.";
        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $sys],
                ['role' => 'user',   'content' => $prompt],
            ],
        ];

        $res = Http::withToken($key)
            ->acceptJson()
            ->post('https://api.openai.com/v1/chat/completions', $payload)
            ->throw();

        $data = $res->json();
        $content = data_get($data, 'choices.0.message.content');
        $promptTokens = data_get($data, 'usage.prompt_tokens');
        $completionTokens = data_get($data, 'usage.completion_tokens');

        return [
            'content' => $content ?? '',
            'model'   => $model,
            'usage'   => ['input' => $promptTokens, 'output' => $completionTokens],
            'raw'     => $data,
        ];
    }
}
