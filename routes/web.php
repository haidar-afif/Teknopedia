<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Contributor\ArticleController as ContributorArticleController;


// ✍️ Area Kontributor / Penulis Artikel
Route::prefix('penulis')->middleware(['auth', 'contributor'])->name('contributor.')->group(function () {
    Route::get('/artikel', [ContributorArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/buat', [ContributorArticleController::class, 'create'])->name('articles.create');
    Route::post('/artikel', [ContributorArticleController::class, 'store'])->name('articles.store');
    Route::get('/artikel/{id}/edit', [ContributorArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/artikel/{id}', [ContributorArticleController::class, 'update'])->name('articles.update');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Public & Auth Routes
Route::get('/', function () {
    $articles = \App\Models\Article::with(['author', 'category'])
        ->where('status', 'published')
        ->latest('updated_at')
        ->take(10)
        ->get();
    return view('home', compact('articles'));
})->name('home');

Route::get('/artikel', function () {
    $articles = \App\Models\Article::with(['author', 'category'])
        ->where('status', 'published')
        ->latest('updated_at')
        ->paginate(9);

    return view('articles.index', compact('articles'));
})->name('articles.index');

Route::get('/artikel/{slug}', function ($slug) {
    $article = \App\Models\Article::with(['author', 'category'])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();
    return view('articles.show', compact('article'));
})->name('articles.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Backward compatibility redirect for /dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});
Route::get('/dashboard/{any}', function () {
    return redirect()->route('admin.dashboard');
})->where('any', '.*');

// 🔐 Admin Dashboard & CMS Routes (RBAC Protected: Auth & Admin Role)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // 1. Dashboard Overview
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Content Management System (CMS)
    Route::prefix('content')->name('content.')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('index');
        Route::get('/create', [ContentController::class, 'create'])->name('create');
        Route::post('/', [ContentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ContentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ContentController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContentController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-status', [ContentController::class, 'toggleStatus'])->name('toggle');
    });

    // 3. User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::patch('/{id}/role', [UserController::class, 'updateRole'])->name('updateRole');
        Route::patch('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // 4. Site Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
    });
});
