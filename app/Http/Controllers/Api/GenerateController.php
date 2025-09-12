<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateContentRequest;
use App\Models\GeneratedContent;
use App\Services\Contracts\ContentGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GenerateController extends Controller
{
    public function __construct(private ContentGenerator $generator) {}

    public function store(GenerateContentRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $result = $this->generator->generate(
                $data['prompt'],
                [
                    'tone'     => $data['tone']     ?? null,
                    'language' => $data['language'] ?? null,
                    'words'    => $data['words']    ?? null,
                ]
            );

            $record = GeneratedContent::create([
                'user_id'       => Auth::id(), // null for now (no auth)
                'title'         => $data['title'] ?? null,
                'prompt'        => $data['prompt'],
                'content'       => $result['content'] ?? '',
                'model'         => $result['model'] ?? null,
                'input_tokens'  => $result['usage']['input']  ?? null,
                'output_tokens' => $result['usage']['output'] ?? null,
                'cost'          => null,
                'meta'          => [
                    'tone'     => $data['tone']     ?? null,
                    'language' => $data['language'] ?? null,
                    'words'    => $data['words']    ?? null,
                ],
            ]);

            return response()->json([
                'id'      => $record->id,
                'content' => $record->content,
                'model'   => $record->model,
                'usage'   => [
                    'input'  => $record->input_tokens,
                    'output' => $record->output_tokens,
                ],
                'saved_at'=> $record->created_at,
            ], 201);

        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'message' => 'Generation failed',
                'error'   => app()->hasDebugModeEnabled() ? $e->getMessage() : null,
            ], 500);
        }
    }
}
