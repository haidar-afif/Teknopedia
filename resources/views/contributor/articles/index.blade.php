@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Dashboard Penulis -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 font-outfit">Dashboard Penulis</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola semua artikel yang pernah kamu buat dan tulis artikel baru di sini.</p>
        </div>
        <div>
           <a href="{{ route('contributor.articles.create') }}"
   class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-md transition-all duration-200">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tambah Artikel Baru
</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Artikel Milik Penulis -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-5">Judul Artikel</th>
                        <th class="py-3.5 px-5">Kategori</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5">Tanggal Dibuat</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($articles as $article)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5 font-semibold text-slate-800">
                                {{ $article->title }}
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-medium">
                                    {{ $article->category->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                @if($article->status === 'published')
                                    <span class="px-2.5 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full">Published</span>
                                @elseif($article->status === 'pending')
                                    <span class="px-2.5 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">Menunggu Approval</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-full">Draft</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-slate-500 text-xs">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ route('contributor.articles.edit', $article->id) }}"
                                   class="text-softcyan-600 hover:text-softcyan-700 font-medium text-xs bg-softcyan-50 px-3 py-1.5 rounded-md">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <p class="text-base font-medium text-slate-600">Kamu belum pernah membuat artikel.</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Artikel Baru" di atas untuk mulai menulis.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
</div>
@endsection
