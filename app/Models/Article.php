<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'subtitle', 'body', 'cover_image', 'status', 'user_id', 'category_id'];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'pubblicato');
    }

    public function scopeSearch(Builder $query, string $term = ''): Builder
    {
        return $query->when($term !== '', fn ($q) => $q->where(fn ($q) => $q
            ->whereFullText(['title', 'subtitle'], $term)
            ->orWhere('title', 'like', "%{$term}%")
            ->orWhere('subtitle', 'like', "%{$term}%")
            ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$term}%"))));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
