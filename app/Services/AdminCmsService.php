<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminCmsService
{
    /**
     * Ensure initial baseline data exists for smooth CMS demonstration.
     */
    public function seedInitialDataIfNeeded(): void
    {
        // 1. Ensure categories exist
        if (Category::count() === 0) {
            $categories = [
                ['name' => 'Web Development', 'slug' => 'web-development'],
                ['name' => 'Backend & Cloud', 'slug' => 'backend-cloud'],
                ['name' => 'Hardware & IoT', 'slug' => 'hardware-iot'],
                ['name' => 'DevOps & Git', 'slug' => 'devops-git'],
                ['name' => 'Cybersecurity', 'slug' => 'cybersecurity'],
            ];
            foreach ($categories as $cat) {
                Category::create($cat);
            }
        }

        // 2. Ensure sample users exist
        if (User::count() <= 1) {
            $sampleUsers = [
                [
                    'name' => 'Siti Nurhaliza',
                    'email' => 'siti@ensiklopedia.it',
                    'role' => 'contributor',
                    'is_active' => true,
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Budi Pratama',
                    'email' => 'budi@ensiklopedia.it',
                    'role' => 'user',
                    'is_active' => true,
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Rian Ardiansyah',
                    'email' => 'rian@ensiklopedia.it',
                    'role' => 'user',
                    'is_active' => false,
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => 'Dewi Anggraini',
                    'email' => 'dewi@ensiklopedia.it',
                    'role' => 'contributor',
                    'is_active' => true,
                    'password' => Hash::make('password'),
                ],
            ];

            foreach ($sampleUsers as $u) {
                if (!User::where('email', $u['email'])->exists()) {
                    User::create($u);
                }
            }
        }

        // 3. Ensure sample articles exist
        if (Article::count() === 0) {
            $admin = User::where('role', 'admin')->first() ?? User::first();
            $webDev = Category::where('slug', 'web-development')->first() ?? Category::first();
            $backend = Category::where('slug', 'backend-cloud')->first() ?? Category::first();
            $devops = Category::where('slug', 'devops-git')->first() ?? Category::first();

            $articles = [
                [
                    'user_id' => $admin?->id ?? 1,
                    'category_id' => $webDev?->id ?? 1,
                    'title' => 'Panduan Komprehensif Arsitektur Microservices Modern',
                    'slug' => 'panduan-komprehensif-arsitektur-microservices-modern',
                    'cover_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                    'tags' => 'Microservices, Docker, Kubernetes, Cloud',
                    'content' => "## Pengenalan Arsitektur Microservices\n\nMicroservices adalah paradigma arsitektur di mana aplikasi dipecah menjadi kumpulan layanan independen yang berkomunikasi melalui API ringan.\n\n### Keunggulan Utama:\n- Skalabilitas horizontal yang elastis\n- Isolasi kegagalan sistem (fault tolerance)\n- Kebebasan memilih teknologi stack antar layanan",
                    'status' => 'published',
                    'created_at' => now()->subDays(2),
                ],
                [
                    'user_id' => $admin?->id ?? 1,
                    'category_id' => $backend?->id ?? 1,
                    'title' => 'Optimasi Performa Query Database MySQL Skala Besar',
                    'slug' => 'optimasi-performa-query-database-mysql-skala-besar',
                    'cover_image' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?auto=format&fit=crop&w=1200&q=80',
                    'tags' => 'MySQL, Database, Indexing, Performance',
                    'content' => "## Mengapa Indexing Krusial?\n\nIndexing yang tepat dapat mengubah query berdurasi beberapa detik menjadi hitungan milidetik. Gunakan EXPLAIN command untuk menganalisis execution plan.\n\n```sql\nEXPLAIN SELECT * FROM orders WHERE status = 'completed' AND created_at >= '2026-01-01';\n```",
                    'status' => 'published',
                    'created_at' => now()->subDays(4),
                ],
                [
                    'user_id' => $admin?->id ?? 1,
                    'category_id' => $devops?->id ?? 1,
                    'title' => 'Implementasi CI/CD Pipeline Otomatis dengan GitHub Actions',
                    'slug' => 'implementasi-cicd-pipeline-otomatis-dengan-github-actions',
                    'cover_image' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?auto=format&fit=crop&w=1200&q=80',
                    'tags' => 'CI/CD, DevOps, GitHub Actions, Deployment',
                    'content' => "## Mengotomatiskan Build dan Deploy\n\nGitHub Actions memungkinkan integrasi berkelanjutan tanpa perlu mengelola server Jenkins terpisah. Berikut adalah konfigurasi workflow dasar.",
                    'status' => 'draft',
                    'created_at' => now()->subHours(8),
                ],
                [
                    'user_id' => $admin?->id ?? 1,
                    'category_id' => $webDev?->id ?? 1,
                    'title' => 'Mastering Tailwind CSS v4: Performa Ekstrem & Fitur Terbaru',
                    'slug' => 'mastering-tailwind-css-v4-performa-ekstrem-dan-fitur-terbaru',
                    'cover_image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80',
                    'tags' => 'Tailwind, CSS, Frontend, Web Design',
                    'content' => "## Fitur Anyar Tailwind v4\n\nTailwind CSS v4 dibangun ulang dengan engine Oxide berkinerja tinggi, menghilangkan ketergantungan pada file `tailwind.config.js` dan sepenuhnya berbasis CSS-first konfigurasi.",
                    'status' => 'published',
                    'created_at' => now()->subDay(),
                ],
            ];

            foreach ($articles as $art) {
                Article::create($art);
            }
        }

        // 4. Ensure site settings exist
        if (Setting::count() === 0) {
            $defaultSettings = [
                'site_name' => 'Ensiklopedia IT',
                'site_tagline' => 'Pusat Pengetahuan & Dokumentasi Teknologi Informasi Indonesia',
                'meta_description' => 'Platform edukasi dan ensiklopedia teknologi terlengkap untuk software engineer, devops, dan pegiat IT Indonesia.',
                'contact_email' => 'redaksi@ensiklopedia.it',
                'contact_phone' => '+62 812-3456-7890',
                'contact_address' => 'Jl. Jenderal Sudirman Kav. 52-53, Jakarta Selatan, Indonesia',
                'social_github' => 'https://github.com/ensiklopedia-it',
                'social_twitter' => 'https://twitter.com/ensiklopedia_it',
                'social_linkedin' => 'https://linkedin.com/company/ensiklopedia-it',
                'site_logo' => '',
                'site_favicon' => '',
            ];

            foreach ($defaultSettings as $key => $val) {
                Setting::set($key, $val);
            }
        }
    }

    /**
     * Dashboard statistics & metrics
     */
    public function getDashboardStats(): array
    {
        $this->seedInitialDataIfNeeded();

        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $contributorCount = User::where('role', 'contributor')->count();
        $regularUserCount = User::where('role', 'user')->count();

        $recentArticles = Article::with(['author', 'category'])
            ->latest('updated_at')
            ->take(6)
            ->get();

        $recentUsers = User::latest('created_at')->take(4)->get();

        return [
            'total_articles' => $totalArticles,
            'published_articles' => $publishedArticles,
            'draft_articles' => $draftArticles,
            'total_users' => $totalUsers,
            'admin_count' => $adminCount,
            'contributor_count' => $contributorCount,
            'regular_user_count' => $regularUserCount,
            'recent_articles' => $recentArticles,
            'recent_users' => $recentUsers,
        ];
    }

    /**
     * Get paginated articles with filter and search
     */
    public function getArticles(?string $search = null, ?string $categoryId = null, ?string $status = null, string $sort = 'latest', int $perPage = 10): LengthAwarePaginator
    {
        $this->seedInitialDataIfNeeded();

        $query = Article::with(['author', 'category']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        if (!empty($categoryId) && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($sort === 'oldest') {
            $query->oldest('created_at');
        } elseif ($sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        } else {
            $query->latest('updated_at');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create article
     */
    public function createArticle(array $data, int $userId): Article
    {
        $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']);
        // Check uniqueness
        $originalSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return Article::create([
            'user_id' => $userId,
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => $slug,
            'cover_image' => $data['cover_image'] ?? null,
            'tags' => $data['tags'] ?? null,
            'content' => $data['content'],
            'status' => $data['status'] ?? 'draft',
        ]);
    }

    /**
     * Update article
     */
    public function updateArticle(int $id, array $data): Article
    {
        $article = Article::findOrFail($id);
        
        $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']);
        // Check uniqueness excluding current
        $originalSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $article->update([
            'category_id' => $data['category_id'] ?? $article->category_id,
            'title' => $data['title'] ?? $article->title,
            'slug' => $slug,
            'cover_image' => array_key_exists('cover_image', $data) ? $data['cover_image'] : $article->cover_image,
            'tags' => array_key_exists('tags', $data) ? $data['tags'] : $article->tags,
            'content' => $data['content'] ?? $article->content,
            'status' => $data['status'] ?? $article->status,
        ]);

        return $article;
    }

    /**
     * Delete article
     */
    public function deleteArticle(int $id): bool
    {
        $article = Article::findOrFail($id);
        return $article->delete();
    }

    /**
     * Toggle article status
     */
    public function toggleArticleStatus(int $id): Article
    {
        $article = Article::findOrFail($id);
        $article->status = $article->status === 'published' ? 'draft' : 'published';
        $article->save();
        return $article;
    }

    /**
     * Get paginated users
     */
    public function getUsers(?string $search = null, ?string $role = null, int $perPage = 10): LengthAwarePaginator
    {
        $this->seedInitialDataIfNeeded();

        $query = User::withCount('articles');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($role) && $role !== 'all') {
            $query->where('role', $role);
        }

        return $query->latest('created_at')->paginate($perPage)->withQueryString();
    }

    /**
     * Update user role
     */
    public function updateUserRole(int $id, string $role): User
    {
        $user = User::findOrFail($id);
        $user->role = in_array($role, ['admin', 'contributor', 'user']) ? $role : 'user';
        $user->save();
        return $user;
    }

    /**
     * Toggle user suspend status
     */
    public function toggleUserStatus(int $id): User
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return $user;
    }

    /**
     * Delete user
     */
    public function deleteUser(int $id): bool
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    /**
     * Get all settings
     */
    public function getSettings(): array
    {
        $this->seedInitialDataIfNeeded();
        return Setting::getAllAsMap();
    }

    /**
     * Update settings map
     */
    public function updateSettings(array $settings): void
    {
        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }
    }
}
