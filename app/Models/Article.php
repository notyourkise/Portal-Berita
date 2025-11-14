<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'author_id',
        'editor_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'cover_image_caption',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'published_at',
        'scheduled_at',
        'views',
        'is_featured',
        'allow_comments',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
        
        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Get the category that owns the article
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the author of the article
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the editor of the article
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    /**
     * Get all tags for the article
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Scope: Get published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope: Get featured articles
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Get draft articles
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope: Get articles in review
     */
    public function scopeInReview($query)
    {
        return $query->where('status', 'review');
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get cover image URL
     */
    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return null;
        }
        
        // Filament stores without 'public/' prefix
        return asset('storage/' . $this->cover_image);
    }

    /**
     * Calculate reading time in minutes
     */
    public function getReadingTimeAttribute()
    {
        // Count words in article body (strip HTML tags)
        $words = str_word_count(strip_tags($this->body));
        
        // Average reading speed: 200 words per minute
        $minutes = ceil($words / 200);
        
        return max(1, $minutes); // Minimum 1 minute
    }

    /**
     * Get reading time as formatted text
     */
    public function getReadingTimeTextAttribute()
    {
        $time = $this->reading_time;
        
        if ($time == 1) {
            return '1 menit';
        }
        
        return $time . ' menit';
    }
}
