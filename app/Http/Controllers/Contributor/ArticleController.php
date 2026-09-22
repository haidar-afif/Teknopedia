<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Tampilkan hanya artikel buatan penulis ini saja
    public function index()
    {
        $articles = Article::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('contributor.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'content' => 'required',
        ]);

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(), // Otomatis mengikat ke ID Kontributor
            'status' => 'pending',     // Perlu moderasi/approval Admin sebelum rilis
        ]);

        return redirect()->route('contributor.articles.index')
            ->with('success', 'Artikel berhasil dikirim dan menunggu persetujuan Admin.');
    }
}
