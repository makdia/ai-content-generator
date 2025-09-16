<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Content Generator</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-3xl bg-white shadow-xl rounded-2xl p-8">
    <!-- Header -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">🚀 AI Content Generator</h1>
        <p class="text-gray-500 mt-2">Generate high-quality content in seconds</p>
    </div>

    <!-- Prompt input -->
    <div class="mb-4">
        <label class="block font-medium text-gray-700 mb-2">Prompt</label>
        <textarea id="prompt" rows="4" placeholder="e.g., Write a blog about healthy eating..."
                  class="w-full p-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
    </div>

    <!-- Options -->
    <div class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block font-medium text-gray-700 mb-1">Tone</label>
            <select id="tone" class="w-full p-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="friendly">Friendly</option>
                <option value="professional">Professional</option>
                <option value="neutral">Neutral</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Language</label>
            <select id="language" class="w-full p-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="en">English</option>
                <option value="bn">Bangla</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Words</label>
            <input type="number" id="words" min="50" max="500" value="150"
                   class="w-full p-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>

    <!-- Generate button -->
    <div class="mb-6 text-center">
        <button id="generateBtn"
                class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold shadow hover:bg-indigo-700 transition">
            Generate ✨
        </button>
    </div>

    <!-- Result display -->
    <div id="resultContainer" class="bg-gray-50 p-8 rounded-xl border border-gray-200 min-h-[120px] relative">
        <p id="result" class="text-gray-700 whitespace-pre-line">Generated content will appear here...</p>
        <button id="copyBtn" 
                class="hidden absolute top-4 right-4 bg-green-500 text-white my-4 px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-green-600">
            📋 Copy
        </button>
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
    const copyBtn = document.getElementById('copyBtn');

    // Typing effect
    function typeText(element, text, speed = 20) {
        element.textContent = '';
        let i = 0;
        const timer = setInterval(() => {
            element.textContent += text.charAt(i);
            i++;
            if (i >= text.length) clearInterval(timer);
        }, speed);
    }

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
        result.textContent = '⏳ Please wait...';
        copyBtn.classList.add('hidden');

        try {
            const response = await axios.post('/api/generate', {
                prompt: prompt,
                tone: tone,
                language: language,
                words: words
            });

            typeText(result, response.data.content);
            copyBtn.classList.remove('hidden');

            // Copy functionality
            copyBtn.onclick = () => {
                navigator.clipboard.writeText(response.data.content);
                copyBtn.textContent = "✅ Copied!";
                setTimeout(() => copyBtn.textContent = "📋 Copy", 2000);
            };

        } catch (error) {
            console.error(error);
            result.textContent = '❌ Error generating content';
            copyBtn.classList.add('hidden');
        } finally {
            button.disabled = false;
            button.textContent = 'Generate ✨';
        }
    });
});
</script>

</body>
</html>
