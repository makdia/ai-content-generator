<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // add auth later
    }

    public function rules(): array
    {
        return [
            'prompt'   => ['required', 'string', 'max:5000'],
            'title'    => ['nullable', 'string', 'max:200'],
            'tone'     => ['nullable', 'string', 'max:50'],     // e.g. "formal"
            'language' => ['nullable', 'string', 'max:50'],     // e.g. "en", "bn"
            'words'    => ['nullable', 'integer', 'min:50', 'max:3000'],
        ];
    }
}
