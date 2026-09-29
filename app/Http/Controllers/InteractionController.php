<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    // Fungsi untuk memproses Rating
    public function storeRating(Request $request, $articleId)
    {
        // 1. Validasi input: score harus angka 1 sampai 5
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        // 2. updateOrCreate: Jika user sudah pernah merating artikel ini, nilainya akan di-update.
        // Jika belum pernah, akan membuat baris data baru.
        Rating::updateOrCreate(
            [
                'article_id' => $articleId,
                'user_id' => Auth::id(), // ID user yang sedang login
            ],
            [
                'score' => $request->score,
            ]
        );

        // 3. Kembali ke halaman artikel sebelumnya
        return back()->with('success', 'Terima kasih, penilaian Anda berhasil disimpan!');
    }

    // Fungsi untuk memproses Komentar
    public function storeComment(Request $request, $articleId)
    {
        // 1. Validasi input: komentar tidak boleh kosong
        $request->validate([
            'content' => 'required|string',
        ]);

        // 2. Simpan komentar baru ke database
        Comment::create([
            'article_id' => $articleId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // 3. Kembali ke halaman artikel sebelumnya
        return back()->with('success', 'Komentar Anda berhasil ditambahkan!');
    }
}
