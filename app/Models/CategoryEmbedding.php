<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryEmbedding extends Model
{
    protected $table = 'embeddings';

    protected $fillable = [
        'category_id',
        'vector',
        'provider',
        'model',
        'dims',
    ];

    protected $casts = [
        'vector' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
