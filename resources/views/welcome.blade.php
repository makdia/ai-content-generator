<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Content Generator</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-3xl bg-white shadow-lg rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">AI Content Generator</h1>

    <!-- Prompt input -->
    <div class="mb-4">
        <label class="block font-medium text-gray-700 mb-2">Prompt</label>
        <textarea id="prompt" rows="4" placeholder="Enter your prompt..."
                  class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
    </div>

    <!-- Options: Tone, Language, Words -->
    <div class="mb-4 flex flex-wrap gap-4 items-center">
        <div>
            <label class="block font-medium text-gray-700 mb-1">Tone</label>
            <select id="tone" class="p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="friendly">Friendly</option>
                <option value="professional">Professional</option>
                <option value="neutral">Neutral</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Language</label>
            <select id="language" class="p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="en">English</option>
                <option value="bn">Bangla</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Words</label>
            <input type="number" id="words" min="50" max="500" value="150"
                   class="w-20 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
    </div>

    <!-- Generate button -->
    <div class="mb-6">
        <button id="generateBtn"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600">
            Generate
        </button>
    </div>

    <!-- Result display -->
    <div id="resultContainer" class="bg-gray-100 p-4 rounded-lg border border-gray-300 min-h-[100px]">
        <p id="result" class="text-gray-700 whitespace-pre-line">Generated content will appear here...</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('generateBtn');
    const promptInput = document.getElementById('prompt');
    const toneSelect = document.getElementById('tone');
    const languageSelect = document.getElementById('language');
    const wordsInput = document.getElementById('words');
    const result = document.getElementById('result');

    button.addEventListener('click', async function() {
        const prompt = promptInput.value.trim();
        const tone = toneSelect.value;
        const language = languageSelect.value;
        const words = parseInt(wordsInput.value) || 150;

        if (!prompt) {
            alert('Please enter a prompt');
            return;
        }

        button.disabled = true;
        button.textContent = 'Generating...';
        result.textContent = '...';

        try {
            const response = await axios.post('/api/generate', {
                prompt: prompt,
                tone: tone,
                language: language,
                words: words
            });

            result.textContent = response.data.content;
        } catch (error) {
            console.error(error);
            result.textContent = '❌ Error generating content';
        } finally {
            button.disabled = false;
            button.textContent = 'Generate';
        }
    });
});
</script>

</body>
</html>
