<?php

namespace App\Http\Controllers;

use App\Helpers\GeminiEmbeddingHelper;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\CategoryEmbedding;
use App\Models\Category;

class SearchController extends Controller
{
    public function showForm()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Generate embedding using Gemini helper
        $queryVector = GeminiEmbeddingHelper::getEmbedding($query);

        if (!$queryVector) {
            return back()->withErrors(['message' => 'Failed to generate embedding from Gemini API']);
        }

        // Get all stored embeddings
        $embeddings = CategoryEmbedding::with('category')->get();

        $maxScore = -INF;
        $bestMatch = null;

        foreach ($embeddings as $embedding) {
            $score = $this->cosineSimilarity($queryVector, $embedding->vector);

            if ($score > $maxScore) {
                $maxScore = $score;
                $bestMatch = $embedding->category;
            }
        }

        return view('search', [
            'results' => [
                'category_name' => $bestMatch?->name ?? 'No match found',
                'score' => number_format($maxScore, 4),
            ],'query'=>$query
        ]);
    }

    // Cosine Similarity Function
    private function cosineSimilarity($a, $b)
    {
        $dotProduct = array_sum(array_map(fn($x, $y) => $x * $y, $a, $b));
        $magnitudeA = sqrt(array_sum(array_map(fn($x) => $x ** 2, $a)));
        $magnitudeB = sqrt(array_sum(array_map(fn($y) => $y ** 2, $b)));

        if ($magnitudeA == 0 || $magnitudeB == 0) return 0;

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }

}
