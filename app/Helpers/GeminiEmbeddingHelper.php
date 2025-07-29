<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GeminiEmbeddingHelper
{
    public static function getEmbedding(string $text): ?array
    {
        $apiKey = env('GEMINI_API_KEY'); // Make sure it's in your .env file

        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/embedding-001:embedContent?key={$apiKey}", [
            'model' => 'models/embedding-001',
            'content' => [
                'parts' => [
                    ['text' => $text]
                ]
            ]
        ]);
        \Log::info("Gemini Response: " . json_encode($response->json()));

        if ($response->successful()) {
            return $response->json('embedding.values');
        }

        return null;
    }
}