@extends('layouts.app')

@section('title', '- ' . $article->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
    <!-- Breadcrumb & Edit Button (Opsional) -->
    <div class="flex items-center justify-between mb-8">
        <nav class="flex text-sm" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="/" class="text-slate-500 hover:text-softred-500 transition-colors">Home</a>
                </li>
                <li>
                    <svg class="h-4 w-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                </li>
                <li>
                    <a href="#" class="text-slate-500 hover:text-softred-500 transition-colors">{{ $article->category->name ?? 'Umum' }}</a>
                </li>
            </ol>
        </nav>
        
        <!-- Tombol Edit (Contoh jika user login & punya akses) -->
        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $article->author_id))
        <a href="{{ route('admin.content.edit', $article->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:text-softcyan-500 hover:bg-softcyan-400/10 border border-transparent hover:border-softcyan-400/30 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
            Edit Artikel
        </a>
        @endif
    </div>

    <!-- Article Header -->
    <header class="mb-12">
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 font-outfit leading-tight mb-6">
            {{ $article->title }}
        </h1>
        
        <div class="flex flex-wrap items-center gap-y-4 gap-x-6 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-softcyan-400/20 flex items-center justify-center text-softcyan-500 font-bold border border-softcyan-400/40">
                    {{ strtoupper(substr($article->author->name ?? 'Admin', 0, 2)) }}
                </div>
                <div>
                    <p class="font-medium text-slate-900">{{ $article->author->name ?? 'Admin' }}</p>
                    <p class="text-slate-500">{{ ucfirst($article->author->role ?? 'Contributor') }}</p>
                </div>
            </div>
            <div class="hidden sm:block w-1.5 h-1.5 rounded-full bg-slate-300"></div>
            <div class="flex items-center gap-2 text-slate-500">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                {{ $article->updated_at ? $article->updated_at->translatedFormat('d F Y') : '-' }}
            </div>
            <div class="hidden sm:block w-1.5 h-1.5 rounded-full bg-slate-300"></div>
            <div class="flex items-center gap-2 text-slate-500">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ $article->reading_time }} menit membaca
            </div>
        </div>
    </header>

    <!-- Cover Image -->
    @if($article->cover_image)
        <div class="w-full h-64 md:h-96 rounded-2xl mb-12 shadow-lg shadow-slate-200/50 relative overflow-hidden">
            <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>
    @else
        <div class="w-full h-64 md:h-96 bg-gradient-to-br from-softcyan-400 to-softcyan-500 rounded-2xl mb-12 shadow-lg shadow-softcyan-400/20 relative overflow-hidden flex items-center justify-center">
            <div class="text-white/50 font-outfit text-4xl md:text-5xl font-bold tracking-widest uppercase text-center px-4">{{ Str::limit($article->title, 20) }}</div>
        </div>
    @endif

    <!-- Article Content (Prose) -->
    <article class="prose prose-slate lg:prose-lg max-w-none prose-headings:font-outfit prose-a:text-softcyan-500 hover:prose-a:text-softcyan-600 prose-img:rounded-xl">
        {!! Str::markdown($article->content) !!}
    </article>

    <!-- Tags & Share -->
    <div class="mt-12 pt-8 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div class="flex flex-wrap gap-2">
            <span class="text-sm font-medium text-slate-900 mr-2 mt-1">Tags:</span>
            @if($article->tags)
                @foreach(explode(',', $article->tags) as $tag)
                    <a href="#" class="px-3 py-1 bg-slate-100 rounded-lg text-sm text-slate-600 hover:bg-softcyan-400/10 hover:text-softcyan-600 transition-colors">{{ trim($tag) }}</a>
                @endforeach
            @else
                <span class="text-sm text-slate-500 mt-1">-</span>
            @endif
        </div>
        
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-slate-900">Bagikan:</span>
            <button class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#1DA1F2] hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
            </button>
            <button class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-[#0A66C2] hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"/></svg>
            </button>
        </div>
    </div>
</div>
@endsection
