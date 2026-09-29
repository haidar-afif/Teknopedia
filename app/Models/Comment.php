<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['article_id', 'user_id', 'content'];

    // Relasi balik ke user agar kita bisa menampilkan nama komentator (seperti di Blade sebelumnya)
    public function user() {
        return $this->belongsTo(User::class);
    }
}
