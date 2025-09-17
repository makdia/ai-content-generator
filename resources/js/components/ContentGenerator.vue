<template>
  <div class="w-full max-w-3xl bg-white shadow-xl rounded-2xl p-8">
    <!-- Header -->
    <div class="text-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">🚀 AI Content Generator</h1>
      <p class="text-gray-500 mt-2">Generate high-quality content in seconds</p>
    </div>

    <!-- Prompt input at top -->
    <div class="mb-6">
      <label class="block font-medium text-gray-700 mb-2">Prompt</label>
      <textarea
        v-model="prompt"
        rows="4"
        placeholder="Enter your prompt here..."
        class="w-full p-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
      ></textarea>
    </div>

    <!-- Options -->
    <div class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div>
        <label class="block font-medium text-gray-700 mb-1">Tone</label>
        <select
          v-model="tone"
          class="w-full p-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
          <option value="friendly">Friendly</option>
          <option value="professional">Professional</option>
          <option value="neutral">Neutral</option>
        </select>
      </div>

      <div>
        <label class="block font-medium text-gray-700 mb-1">Language</label>
        <select
          v-model="language"
          class="w-full p-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
          <option value="en">English</option>
          <option value="bn">Bangla</option>
        </select>
      </div>

      <div>
        <label class="block font-medium text-gray-700 mb-1">Words</label>
        <input
          type="number"
          v-model.number="words"
          min="50"
          max="500"
          class="w-full p-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
      </div>
    </div>

    <!-- Generate button -->
    <div class="mb-6 text-center">
      <button
        @click="generateContent"
        :disabled="loading"
        class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold shadow hover:bg-indigo-700 transition disabled:opacity-50"
      >
        {{ loading ? "Generating..." : "Generate ✨" }}
      </button>
    </div>

    <!-- Result display -->
    <div class="bg-gray-50 p-8 rounded-xl border border-gray-200 min-h-[120px] relative">
      <p class="text-gray-700 whitespace-pre-line">{{ displayText || 'Generated content will appear here...' }}</p>
      <button v-if="promptGenerated && !error"
              @click="copyContent"
              class="absolute top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-green-600">
        {{ copied ? '✅ Copied!' : '📋 Copy' }}
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ContentGenerator",
  data() {
    return {
      prompt: "",
      tone: "friendly",
      language: "en",
      words: 150,
      displayText: "",
      promptGenerated: false,
      loading: false,
      copied: false,
      error: false,
    };
  },
  methods: {
    async generateContent() {
      if (!this.prompt.trim()) {
        alert("Please enter a prompt");
        return;
      }

      this.loading = true;
      this.displayText = "⏳ Please wait...";
      this.promptGenerated = false;
      this.copied = false;
      this.error = false;

      try {
        const response = await axios.post("/api/generate", {
          prompt: this.prompt,
          tone: this.tone,
          language: this.language,
          words: this.words,
        });

        // Smooth typing animation
        this.displayText = "";
        this.promptGenerated = false;
        const text = response.data.content;
        let i = 0;
        const interval = setInterval(() => {
          this.displayText += text.charAt(i);
          i++;
          if (i >= text.length) {
            clearInterval(interval);
            this.promptGenerated = true; // enable copy button
          }
        }, 20); // 20ms per character
      } catch (e) {
        console.error(e);
        this.displayText = "❌ Error generating content";
        this.error = true;
      } finally {
        this.loading = false;
      }
    },
    copyContent() {
      navigator.clipboard.writeText(this.displayText);
      this.copied = true;
      setTimeout(() => (this.copied = false), 2000);
    },
  },
};
</script>

<style scoped>
button {
  transition: all 0.2s;
}
</style>
