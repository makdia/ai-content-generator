<?php

namespace App\Services\Contracts;

interface ContentGenerator
{
    /**
     * @param string $prompt
     * @param array $options ['tone' => 'formal', 'language' => 'en', 'words' => 300, ...]
     * @return array ['content' => string, 'model' => ?string, 'usage' => ['input'=>?int,'output'=>?int], 'raw' => mixed]
     */
    public function generate(string $prompt, array $options = []): array;
}
