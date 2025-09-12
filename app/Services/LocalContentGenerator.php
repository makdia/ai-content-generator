<?php

namespace App\Services;

use App\Services\Contracts\ContentGenerator;

class LocalContentGenerator implements ContentGenerator
{
    public function generate(string $prompt, array $options = []): array
    {
        $tone = $options['tone'] ?? 'neutral';
        $language = strtolower($options['language'] ?? 'en');
        $words = (int)($options['words'] ?? 180);

        $body = $this->fakeParagraph($prompt, $tone, $language, $words);

        return [
            'content' => $body,
            'model'   => 'local-fake',
            'usage'   => ['input' => strlen($prompt), 'output' => strlen($body)],
            'raw'     => null,
        ];
    }

    private function fakeParagraph(string $prompt, string $tone, string $lang, int $words): string
{
    switch ($lang) {
        case 'bn':
        case 'bangla':
            $prefix = 'এই লেখাটি একটি ডেমো জেনারেশন (লোকাল) —';
            break;
        default:
            $prefix = 'This is a demo generation (local) —';
    }

    $toneLine = " tone: {$tone}";
    $hint = ($lang === 'bn' || $lang === 'bangla')
        ? " প্রম্পট: {$prompt}"
        : " prompt: {$prompt}";

    $base = "$prefix$toneLine$hint. ";

    // naive word filler
    $filler = ($lang === 'bn' || $lang === 'bangla')
        ? 'বিষয়বস্তু, অনুচ্ছেদ, তথ্য, সারাংশ'
        : 'content, paragraph, details, summary';

    $tokens = explode(',', $filler);
    while (str_word_count($base) < $words) {
        $base .= ' ' . trim($tokens[array_rand($tokens)]) . '.';
    }
    return trim($base);
}

}
