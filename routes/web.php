<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\Contracts\ContentGenerator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-ai', function (ContentGenerator $generator) {
    $result = $generator->generate("Write a short blog intro about Laravel + AI.", [
        'tone' => 'friendly',
        'language' => 'en',
        'words' => 100,
    ]);
    return response()->json($result);
});

// Route::post('/api/generate', function (Request $request, ContentGenerator $generator) {
//     $validated = $request->validate([
//         'prompt' => 'required|string|max:500',
//         'tone'   => 'nullable|string',
//         'language' => 'nullable|string',
//         'words'  => 'nullable|integer|min:50|max:500',
//     ]);

//     return $generator->generate(
//         $validated['prompt'],
//         [
//             'tone'     => $validated['tone'] ?? 'neutral',
//             'language' => $validated['language'] ?? 'en',
//             'words'    => $validated['words'] ?? 150,
//         ]
//     );
// });