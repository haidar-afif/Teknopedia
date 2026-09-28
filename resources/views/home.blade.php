@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white dark:bg-slate-900 overflow-hidden border-b border-softcyan-400/30 dark:border-slate-800 transition-colors duration-300">
    <!-- Floating Badges Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-softcyan-400/20 to-white dark:from-softcyan-900/10 dark:to-slate-900 transition-colors duration-300"></div>
        
        <!-- Floating Topic Badges (Left) -->
        <div class="absolute top-[20%] left-[5%] lg:left-[10%] px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg rounded-full border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm animate-float opacity-70" style="animation-duration: 4s;">
            🚀 React
        </div>
        <div class="absolute top-[60%] left-[2%] lg:left-[8%] px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg rounded-full border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm animate-float opacity-60" style="animation-duration: 6s; animation-delay: 1s;">
            🔥 Laravel
        </div>
        <div class="absolute bottom-[15%] left-[10%] lg:left-[15%] px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg rounded-full border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm animate-float opacity-50" style="animation-duration: 5s; animation-delay: 2s;">
            🤖 AI
        </div>

        <!-- Floating Topic Badges (Right) -->
        <div class="absolute top-[25%] right-[5%] lg:right-[12%] px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg rounded-full border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm animate-float opacity-70" style="animation-duration: 5.5s; animation-delay: 0.5s;">
            🐍 Python
        </div>
        <div class="absolute top-[50%] right-[8%] lg:right-[15%] px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg rounded-full border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm animate-float opacity-60" style="animation-duration: 4.5s; animation-delay: 1.5s;">
            ☁️ Cloud
        </div>
        <div class="absolute bottom-[20%] right-[4%] lg:right-[10%] px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg rounded-full border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium text-sm animate-float opacity-50" style="animation-duration: 6.5s; animation-delay: 2.5s;">
            🎨 Tailwind CSS
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-700 dark:text-slate-100 tracking-tight font-outfit mb-6 transition-colors">
                Eksplorasi Dunia <span class="text-transparent bg-clip-text bg-gradient-to-r from-softred-500 to-softcyan-500">Teknologi</span> Tanpa Batas
            </h1>
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 mb-10 transition-colors">
                Temukan ribuan artikel, tutorial, dan solusi error code dari praktisi IT berpengalaman. Tingkatkan skill coding kamu hari ini.
            </p>
        </div>
    </div>
</div>

<!-- Main Content Area (Grid + Sidebar) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-10">

       <!-- Left: Article Grid -->
<div class="max-w-4xl mx-auto w-full px-4">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-slate-700 dark:text-slate-100 font-outfit">Artikel Terbaru</h2>
        <a href="{{ route('articles.index') }}" class="text-sm font-medium text-softred-500 hover:text-softred-400 transition-colors">Lihat Semua &rarr;</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($articles as $article)
            <article class="group bg-white dark:bg-slate-800 rounded-2xl border border-softcyan-400/30 dark:border-slate-700 shadow-sm hover:shadow-xl hover:shadow-softcyan-400/10 dark:hover:shadow-softcyan-400/5 transition-all duration-300 overflow-hidden flex flex-col">

                <!-- 1. GAMBAR COVER (Bisa diklik ke detail) -->
                <a href="{{ route('articles.show', $article->slug) }}" class="h-48 w-full bg-gradient-to-br from-softcyan-400 to-softred-400 relative overflow-hidden block">
                    @if($article->cover_image)
                        <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-white/10 group-hover:bg-transparent transition-colors"></div>
                </a>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-softcyan-400/20 text-slate-700 dark:text-slate-300 border border-softcyan-400 dark:border-slate-600">
                            {{ $article->category->name ?? 'Umum' }}
                        </span>  
                        <span class="text-xs text-slate-500">{{ $article->updated_at->format('d M Y') }}</span>
                    </div>

                    <!-- 2. JUDUL ARTIKEL (Bisa diklik ke detail) -->
                    <h3 class="text-xl font-bold text-slate-700 dark:text-slate-200 font-outfit mb-2 group-hover:text-softred-500 dark:group-hover:text-softred-400 transition-colors leading-tight">
                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                    </h3>

                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 line-clamp-2 flex-1">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>

                    <div class="flex items-center gap-3 pt-4 border-t border-softcyan-400/20 dark:border-slate-700">
                        <div class="w-8 h-8 rounded-full bg-softred-400/20 flex items-center justify-center text-slate-700 dark:text-slate-300 font-bold text-xs border border-softred-400 dark:border-softred-500">
                            {{ strtoupper(substr($article->author->name ?? 'A', 0, 2)) }}
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $article->author->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-1 md:col-span-2 text-center py-12">
                <p class="text-slate-500">Belum ada artikel yang tersedia.</p>
            </div>
            <!-- Link Pagination Tailwind -->
                <div class="mt-8">
                   {{ $articles->links() }}
            </div>
        @endforelse
    </div>
</div>
        </div>
    </div>
</div>
@endsection
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

