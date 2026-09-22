@extends('layouts.app')

@section('title', '- Semua Artikel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 font-outfit">
            @if(request('search'))
                Hasil Pencarian: "{{ request('search') }}"
            @else
                Semua Artikel
            @endif
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            @if(request('search'))
                Menampilkan artikel yang cocok dengan kata kunci pencarian kamu.
            @else
                Jelajahi seluruh koleksi artikel dan wawasan terbaru.
            @endif
        </p>
    </div>

    <!-- Grid Artikel -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <article class="group bg-white rounded-2xl border border-softcyan-400/30 shadow-sm hover:shadow-xl hover:shadow-softcyan-400/10 transition-all duration-300 overflow-hidden flex flex-col">
                <a href="{{ route('articles.show', $article->slug) }}" class="h-48 w-full bg-gradient-to-br from-softcyan-400 to-softred-400 block relative overflow-hidden">
                    @if($article->cover_image)
                        <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    @endif
                </a>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 mb-3 text-xs text-slate-500">
                        <span class="px-2.5 py-0.5 rounded-full font-medium bg-softcyan-400/20 text-slate-700 border border-softcyan-400">
                            {{ $article->category->name ?? 'Umum' }}
                        </span>
                        <span>•</span>
                        <span>{{ $article->updated_at->format('d M Y') }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-700 font-outfit mb-2 group-hover:text-softred-500 transition-colors leading-tight">
                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                    </h3>

                    <p class="text-sm text-slate-600 mb-4 line-clamp-2 flex-1">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>

                    <div class="flex items-center gap-3 pt-4 border-t border-softcyan-400/20">
                        <div class="w-7 h-7 rounded-full bg-softred-400/20 flex items-center justify-center text-slate-700 font-bold text-xs border border-softred-400">
                            {{ strtoupper(substr($article->author->name ?? 'A', 0, 2)) }}
                        </div>
                        <span class="text-xs font-medium text-slate-700">{{ $article->author->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-dashed border-slate-200">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-slate-600 font-medium text-base">
                    @if(request('search'))
                        Tidak ditemukan artikel dengan kata kunci "{{ request('search') }}"
                    @else
                        Belum ada artikel yang tersedia.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('articles.index') }}" class="inline-block mt-4 text-xs font-semibold text-softcyan-600 hover:underline">
                        ← Tampilkan semua artikel
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Tombol Halaman (Pagination) -->
    <div class="mt-10">
        {{ $articles->links() }}
    </div>
</div>
@endsection
