<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'image_url',
        'author',
        'is_published',
        'slug',
        'reading_time',
        'tags',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'reading_time' => 'integer',
        'tags' => 'array',
    ];

    public function getFormattedTagsAttribute()
    {
        return collect($this->tags)->map(function ($tag) {
            return [
                'name' => $tag,
                'slug' => \Str::slug($tag),
            ];
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
} 