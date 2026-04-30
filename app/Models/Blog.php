<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'category',
        'status',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title) . '-' . Str::random(5);
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
