<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GenerateController;
use App\Services\Contracts\ContentGenerator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/generate', [GenerateController::class, 'store'])
    ->middleware('throttle:20,1'); // 20 requests/min


    Route::post('/generate', function (Request $request, ContentGenerator $generator) {
        $validated = $request->validate([
            'prompt' => 'required|string|max:500',
            'tone'   => 'nullable|string',
            'language' => 'nullable|string',
            'words'  => 'nullable|integer|min:50|max:500',
        ]);
    
        return $generator->generate(
            $validated['prompt'],
            [
                'tone'     => $validated['tone'] ?? 'neutral',
                'language' => $validated['language'] ?? 'en',
                'words'    => $validated['words'] ?? 150,
            ]
        );
    });