<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'cover_image',
        'tags',
        'content',
        'status',
    ];

    /**
     * Estimated reading time in minutes.
     * Uses 200 WPM (standard for Indonesian technical content).
     * Accessible via $article->reading_time
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        return max(1, (int) round($wordCount / 200));
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Di dalam app/Models/Article.php

// Relasi One-to-Many: Satu artikel punya banyak komentar
public function comments() {
    return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
}

// Relasi One-to-Many: Satu artikel punya banyak rating
public function ratings() {
    return $this->hasMany(Rating::class);
}

// Fungsi opsional untuk menghitung rata-rata rating
public function averageRating() {
    return $this->ratings()->avg('score') ?: 0;
}
}
