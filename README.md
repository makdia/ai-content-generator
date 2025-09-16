# AI-Powered Content Generator

A Laravel-based platform that generates content using AI. Users can input a prompt, select tone, language, and word count, then get AI-generated content instantly. Supports both OpenAI GPT API and a local fallback generator.

## Features

- Generate content using **OpenAI GPT** (optional) or **local fake generator**.
- Adjustable **tone**, **language**, and **word count**.
- Fully functional with **plain JS + Axios** (no Vue required).
- Styled with **Tailwind CSS**.
- Copy generated content to clipboard.

## Installation

1. Clone the repository:

```bash
git clone https://github.com/makdia/ai-content-generator.git
cd content-generator

2. Install PHP dependencies:

composer install

3. Install Node.js dependencies:

npm install


4. Compile assets:

npm run dev


5. Copy .env.example to .env and configure:

cp .env.example .env
php artisan key:generate

6. Run migrations:

php artisan migrate


7. Serve the application:

php artisan serve  


## Usage

1. Navigate to http://localhost:8000

2. Enter your prompt in the input field.

3. Click Generate to create AI-generated content.


## Environment Variables

Update your .env file with:

OPENAI_API_KEY=your_api_key_here