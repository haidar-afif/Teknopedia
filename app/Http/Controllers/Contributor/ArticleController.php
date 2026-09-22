<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Tampilkan hanya artikel buatan penulis yang sedang login
    public function index(Request $request)
    {
        $search = $request->input('search');

        $articles = Article::where('user_id', auth()->id())
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // DIPERBAIKI: Mengarahkan ke view dashboard penulis
        return view('contributor.articles.index', compact('articles'));
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
            'category_id' => 'required|exists:categories,id',
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

    public function edit($id)
    {
        // Pastikan penulis hanya bisa mengedit artikel miliknya sendiri
        $article = Article::where('user_id', auth()->id())->findOrFail($id);
        $categories = Category::all();

        return view('contributor.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
        ]);

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'status' => 'pending', // Kembali ke pending jika diedit (opsional)
        ]);

        return redirect()->route('contributor.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }
}
