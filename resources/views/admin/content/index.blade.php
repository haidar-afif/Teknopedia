@extends('layouts.admin')

@section('title', 'Kelola Konten & CMS')
@section('header_title', 'Kelola Konten (CMS)')

@section('content')
    <!-- Action Bar & Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold font-outfit text-slate-900">Daftar Artikel Ensiklopedia</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola seluruh publikasi, draft artikel, dan materi teknologi informasi.</p>
        </div>
        <a href="{{ route('admin.content.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-softred-500 hover:bg-softred-400 shadow-md shadow-softred-500/20 transition-all hover:scale-[1.02]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            <span>Tambah Artikel Baru</span>
        </a>
    </div>

    <!-- Filters, Search & Sorting Toolbar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.content.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5">
            <!-- Search Bar (5 cols) -->
            <div class="lg:col-span-4 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, tag, atau isi..." class="block w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
            </div>

            <!-- Filter Kategori (3 cols) -->
            <div class="lg:col-span-3">
                <select name="category" onchange="this.form.submit()" class="block w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 text-slate-700">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status (2 cols) -->
            <div class="lg:col-span-2">
                <select name="status" onchange="this.form.submit()" class="block w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 text-slate-700">
                    <option value="all">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <!-- Sorting (2 cols) -->
            <div class="lg:col-span-2">
                <select name="sort" onchange="this.form.submit()" class="block w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 text-slate-700">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                </select>
            </div>

            <!-- Reset / Search button (1 col) -->
            <div class="lg:col-span-1 flex items-center gap-1">
                <button type="submit" class="w-full flex items-center justify-center p-2 rounded-xl bg-softcyan-400 hover:bg-softcyan-500 text-slate-800 text-xs font-semibold shadow-xs transition-colors" title="Terapkan Filter">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                </button>
                @if(request('search') || request('category') || request('status') || request('sort'))
                    <a href="{{ route('admin.content.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 text-xs transition-colors" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Content Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold uppercase text-slate-500 tracking-wider">
                        <th class="py-3.5 px-4 sm:px-6">Artikel & Info</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Tanggal Update</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($articles as $article)
                        <tr class="hover:bg-slate-50/70 transition-colors group">
                            <!-- Judul & Cover Thumbnail -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                        @if($article->cover_image)
                                            <img src="{{ $article->cover_image }}" alt="Cover" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-softcyan-400/20 text-softcyan-500 font-bold text-xs">
                                                IT
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.content.edit', $article->id) }}" class="font-semibold text-slate-800 hover:text-softred-500 line-clamp-1 text-sm transition-colors">
                                            {{ $article->title }}
                                        </a>
                                        <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-0.5">
                                            <span>Penulis: <strong class="text-slate-600">{{ $article->author->name ?? 'Admin' }}</strong></span>
                                            @if($article->tags)
                                                <span>&bull;</span>
                                                <span class="text-slate-500 font-mono text-[10px] bg-slate-100 px-1.5 py-0.2 rounded">{{ Str::limit($article->tags, 30) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $article->category->name ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Status Toggle -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <form method="POST" action="{{ route('admin.content.toggle', $article->id) }}" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Klik untuk mengubah status" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider transition-all {{ $article->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $article->status === 'published' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                        {{ $article->status === 'published' ? 'Published' : 'Draft' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Tanggal -->
                            <td class="py-4 px-4 whitespace-nowrap text-slate-500 text-xs">
                                {{ $article->updated_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                                <div class="text-[10px] text-slate-400">{{ $article->updated_at ? $article->updated_at->format('H:i') : '' }} WIB</div>
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="py-4 px-4 sm:px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Preview -->
                                    <a href="{{ url('/artikel/contoh') }}" target="_blank" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors" title="Lihat di Frontend">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.content.edit', $article->id) }}" class="p-2 text-softcyan-500 hover:text-softcyan-600 hover:bg-softcyan-400/20 rounded-xl transition-colors" title="Sunting Artikel">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>

                                    <!-- Delete (With Confirmation Modal) -->
                                    <button type="button"
                                            onclick="openConfirmModal({
                                                title: 'Hapus Artikel',
                                                message: 'Apakah Anda yakin ingin menghapus artikel &ldquo;{{ addslashes($article->title) }}&rdquo;? Aksi ini permanen.',
                                                action: '{{ route('admin.content.destroy', $article->id) }}',
                                                method: 'DELETE',
                                                confirmText: 'Hapus Artikel',
                                                isDestructive: true
                                            })"
                                            class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-colors"
                                            title="Hapus Artikel">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <p class="text-sm font-semibold text-slate-600">Tidak ada konten ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter kategori Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="p-4 border-t border-slate-100 flex items-center justify-between">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
@endsection
