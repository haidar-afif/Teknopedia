<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['article_id', 'user_id', 'score'];

    // Opsional: Relasi balik ke user jika ingin menampilkan nama perating
    public function user() {
        return $this->belongsTo(User::class);
    }
}
