<?php

namespace App\Console\Commands;

use App\Helpers\EmbeddingSearchHelper;
use App\Helpers\GeminiEmbeddingHelper;
use App\Models\Category;
use App\Models\CategoryEmbedding;
use Illuminate\Console\Command;

class GenerateCategoryEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:category-embeddings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate embeddings for all categories using Gemini';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔄 Generating category embeddings using Gemini...");

        $categories = Category::all();

        foreach ($categories as $category) {
            $embedding = GeminiEmbeddingHelper::getEmbedding($category->name);
            if ($embedding) {
                CategoryEmbedding::updateOrCreate(
                    ['category_id' => $category->id],
                    [
                        'vector' => $embedding,
                        'provider' => 'gemini',
                        'model' => 'embedding-001',
                        'dims' => count($embedding),
                    ]
                );
            } else {
                $this->error("✗ Failed to embed: {$category->name}");
            }
        }

        $this->info("✅ Embedding generation complete.");
    }
}
