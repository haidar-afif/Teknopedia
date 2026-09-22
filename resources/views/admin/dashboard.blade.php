@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('header_title', 'Ringkasan Dashboard')

@section('content')

        <!-- Decorative abstract glow -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-softred-400/30 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Cards Metric -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Total Konten -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Artikel</p>
                    <h3 class="text-2xl sm:text-3xl font-bold font-outfit text-slate-800 mt-1">{{ $stats['total_articles'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-softcyan-400/20 flex items-center justify-center text-softcyan-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14" /></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-medium text-slate-500">
                <span class="inline-flex items-center text-emerald-600 font-semibold">
                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                    Semua Kategori
                </span>
                <span>tercatat di database</span>
            </div>
        </div>

        <!-- Artikel Terpublikasi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Artikel Terbit</p>
                    <h3 class="text-2xl sm:text-3xl font-bold font-outfit text-emerald-600 mt-1">{{ $stats['published_articles'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-medium text-slate-500">
                <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-semibold">Status Live</span>
                <span>dapat dibaca publik</span>
            </div>
        </div>

        <!-- Draft Konten -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Draft / Arsip</p>
                    <h3 class="text-2xl sm:text-3xl font-bold font-outfit text-amber-600 mt-1">{{ $stats['draft_articles'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-medium text-slate-500">
                <span class="text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-semibold">Dalam Pengerjaan</span>
                <span>belum tayang</span>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pengguna</p>
                    <h3 class="text-2xl sm:text-3xl font-bold font-outfit text-slate-900 mt-1">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center text-sky-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-medium text-slate-500">
                <span class="text-sky-700 font-semibold">{{ $stats['admin_count'] }} Admin</span> &bull;
                <span>{{ $stats['contributor_count'] }} Penulis</span> &bull;
                <span>{{ $stats['regular_user_count'] }} User</span>
            </div>
        </div>

    </div>

    <!-- Tables Grid: Recent Content & Recent Users -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Articles Table (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-outfit font-bold text-base text-slate-800">Konten Baru Saja Diperbarui</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar artikel yang baru dibuat atau diubah baru-baru ini</p>
                </div>
                <a href="{{ route('admin.content.index') }}" class="text-xs font-semibold text-softcyan-500 hover:text-softred-500 flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold uppercase text-slate-500 tracking-wider">
                            <th class="py-3 px-4">Judul Artikel</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Terakhir Diubah</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($stats['recent_articles'] as $article)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4">
                                    <div class="font-medium text-slate-900 line-clamp-1 max-w-xs">{{ $article->title }}</div>
                                    <div class="text-[11px] text-slate-400">Oleh: {{ $article->author->name ?? 'Admin' }}</div>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700">
                                        {{ $article->category->name ?? 'Teknologi' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($article->status === 'published')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-slate-500 text-[11px]">
                                    {{ $article->updated_at ? $article->updated_at->diffForHumans() : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin.content.edit', $article->id) }}" class="p-1.5 text-softcyan-500 hover:bg-softcyan-400/20 rounded-lg transition-colors" title="Edit Artikel">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <a href="{{ url('/artikel/contoh') }}" target="_blank" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors" title="Preview Artikel">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Belum ada artikel yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Users (1 Col) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-outfit font-bold text-base text-slate-900">Pengguna Terdaftar</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pengguna dan kontributor sistem</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Semua</a>
                </div>

                <div class="mt-4 space-y-3.5">
                    @foreach($stats['recent_users'] as $u)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-softcyan-400/20 text-softcyan-500 font-bold text-xs flex items-center justify-center border border-softcyan-400/40">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-800">{{ $u->name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $u->email }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $u->role === 'admin' ? 'bg-softred-400/20 text-softred-500' : ($u->role === 'contributor' ? 'bg-softcyan-400/20 text-softcyan-500' : 'bg-slate-100 text-slate-700') }}">
                                {{ $u->role }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
        </div>

    </div>
@endsection
