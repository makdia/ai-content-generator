<template>
    <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg p-8 mx-auto">
      <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">AI Content Generator</h1>
  
      <!-- Prompt -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700 mb-2">Prompt</label>
        <textarea v-model="prompt" rows="4" placeholder="Enter your prompt..."
                  class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
      </div>
  
      <!-- Options -->
      <div class="mb-4 flex flex-wrap gap-4 items-center">
        <div>
          <label class="block font-medium text-gray-700 mb-1">Tone</label>
          <select v-model="tone" class="p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="friendly">Friendly</option>
            <option value="professional">Professional</option>
            <option value="neutral">Neutral</option>
          </select>
        </div>
  
        <div>
          <label class="block font-medium text-gray-700 mb-1">Language</label>
          <select v-model="language" class="p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="en">English</option>
            <option value="bn">Bangla</option>
          </select>
        </div>
  
        <div>
          <label class="block font-medium text-gray-700 mb-1">Words</label>
          <input type="number" v-model.number="words" min="50" max="500" 
                 @input="words = Math.min(Math.max(50, words), 500)"
                 class="w-20 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
      </div>
  
      <!-- Generate button -->
      <div class="mb-6">
        <button @click="generateContent" :disabled="loading"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 disabled:opacity-50">
          {{ loading ? 'Generating...' : 'Generate' }}
        </button>
      </div>
  
      <!-- Result -->
      <div v-if="result" class="bg-gray-100 p-4 rounded-lg border border-gray-300">
        <h3 class="font-semibold mb-2 text-gray-800">Generated Content:</h3>
        <p class="text-gray-700 whitespace-pre-line">{{ result }}</p>
  
        <button v-if="result !== '❌ Error generating content'" @click="copyToClipboard"
                class="mt-3 bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
          Copy to Clipboard
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: "AIForm",
    data() {
      return {
        prompt: '',
        tone: 'friendly',
        language: 'en',
        words: 150,
        result: null,
        loading: false,
      };
    },
    methods: {
      async generateContent() {
        if (!this.prompt.trim()) {
          alert('Please enter a prompt');
          return;
        }
  
        this.loading = true;
        this.result = null;
  
        try {
          const response = await axios.post('/api/generate', {
            prompt: this.prompt,
            tone: this.tone,
            language: this.language,
            words: this.words
          });
  
          this.result = response.data.content;
        } catch (error) {
          console.error(error);
          this.result = '❌ Error generating content';
        } finally {
          this.loading = false;
        }
      },
      copyToClipboard() {
        if (!this.result) return;
        navigator.clipboard.writeText(this.result)
          .then(() => alert('Copied to clipboard!'))
          .catch(err => console.error(err));
      }
    }
  }
  </script>
  
  <style scoped>
  /* Optional: local component styles */
  </style>
  