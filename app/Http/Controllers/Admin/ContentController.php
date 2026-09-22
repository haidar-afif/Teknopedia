<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Services\AdminCmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    protected AdminCmsService $cmsService;

    public function __construct(AdminCmsService $cmsService)
    {
        $this->cmsService = $cmsService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category');
        $status = $request->query('status');
        $sort = $request->query('sort', 'latest');

        $articles = $this->cmsService->getArticles($search, $categoryId, $status, $sort, 10);
        $categories = Category::all();

        return view('admin.content.index', compact('articles', 'categories', 'search', 'categoryId', 'status', 'sort'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.content.form', [
            'article' => new Article(),
            'categories' => $categories,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category_id.required' => 'Kategori artikel wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'content.required' => 'Bodi konten artikel wajib diisi.',
        ]);

        $this->cmsService->createArticle($validated, Auth::id() ?? 1);

        return redirect()->route('admin.content.index')->with('success', 'Artikel berhasil dibuat dan disimpan!');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();

        return view('admin.content.form', [
            'article' => $article,
            'categories' => $categories,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category_id.required' => 'Kategori artikel wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'content.required' => 'Bodi konten artikel wajib diisi.',
        ]);

        $this->cmsService->updateArticle($id, $validated);

        return redirect()->route('admin.content.index')->with('success', 'Perubahan artikel berhasil disimpan!');
    }

    public function destroy($id)
    {
        $this->cmsService->deleteArticle($id);
        return redirect()->route('admin.content.index')->with('success', 'Artikel berhasil dihapus dari sistem!');
    }

    public function toggleStatus($id)
    {
        $article = $this->cmsService->toggleArticleStatus($id);
        $statusLabel = $article->status === 'published' ? 'Dipublikasikan' : 'Disimpan sebagai Draft';
        return redirect()->back()->with('success', "Status artikel diperbarui menjadi {$statusLabel}!");
    }
}
