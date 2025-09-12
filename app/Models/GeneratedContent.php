<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedContent extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'title', 'prompt', 'content',
        'model', 'input_tokens', 'output_tokens', 'cost', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
