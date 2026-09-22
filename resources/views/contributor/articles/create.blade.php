@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

        <form action="{{ route('contributor.articles.store') }}" method="POST" id="articleForm">
            @csrf

            <!-- Top Header & Action Buttons -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <a href="{{ route('contributor.articles.index') }}"
                       class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors mb-2">
                        ← Kembali ke Daftar Artikel
                    </a>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight font-outfit">Buat Artikel Baru</h1>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('contributor.articles.index') }}"
                       class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold text-sm rounded-xl hover:bg-slate-100 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" name="status" value="draft"
                            class="px-5 py-2.5 bg-amber-50 border border-amber-200 text-amber-800 font-semibold text-sm rounded-xl hover:bg-amber-100 transition-colors shadow-sm">
                        Simpan Draft
                    </button>
                    <button type="submit" name="status" value="pending"
                            class="px-5 py-2.5 bg-emerald-400 hover:bg-emerald-500 text-slate-900 font-bold text-sm rounded-xl transition-colors shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Publikasikan Sekarang
                    </button>
                </div>
            </div>

            <!-- Grid Layout (Main Content & Sidebar) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column (Main Form) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Judul & Slug Card -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                        <div>
                            <label for="title" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">
                                Judul Artikel <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title') }}"
                                placeholder="Contoh: Arsitektur Microservices Modern dengan Docker & Kubernetes"
                                class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-white transition-all font-medium"
                                required
                            >
                        </div>
                    </div>

                    <!-- Editor Content Card -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <!-- Toolbar Editor -->
                        <div class="p-3 bg-slate-50/80 border-b border-slate-200/80 flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-1 bg-slate-200/60 p-1 rounded-lg">
                                <button type="button" class="px-3 py-1 bg-white text-red-500 font-bold text-xs rounded-md shadow-sm">Tulis Konten</button>
                                <button type="button" class="px-3 py-1 text-slate-600 font-medium text-xs hover:text-slate-900">Live Preview</button>
                            </div>

                            <div class="flex items-center gap-2 text-slate-600 font-bold text-xs">
                                <button type="button" class="w-7 h-7 flex items-center justify-center hover:bg-slate-200 rounded">B</button>
                                <button type="button" class="w-7 h-7 flex items-center justify-center italic hover:bg-slate-200 rounded">I</button>
                                <span class="text-slate-300">|</span>
                                <button type="button" class="px-1.5 hover:bg-slate-200 rounded">H2</button>
                                <button type="button" class="px-1.5 hover:bg-slate-200 rounded">H3</button>
                                <span class="text-slate-300">|</span>
                                <button type="button" class="px-1.5 hover:bg-slate-200 rounded font-mono">&lt;/&gt;</button>
                                <button type="button" class="px-1.5 hover:bg-slate-200 rounded">≡</button>
                                <button type="button" class="px-1.5 hover:bg-slate-200 rounded">“</button>
                                <button type="button" class="px-1.5 hover:bg-slate-200 rounded">🔗</button>
                            </div>
                        </div>

                        <!-- Textarea Area -->
                        <textarea
                            name="content"
                            id="content"
                            rows="16"
                            placeholder="Tulis isi artikel dengan format Markdown atau teks terstruktur..."
                            class="w-full p-5 border-0 focus:ring-0 text-slate-800 text-sm placeholder-slate-400 font-mono resize-y"
                            required
                        >{{ old('content') }}</textarea>

                        <!-- Footer Editor -->
                        <div class="px-5 py-3 bg-slate-50/50 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-400">
                            <span>Format: Markdown Didukung</span>
                            <span id="wordCount">0 kata</span>
                        </div>
                    </div>

                </div>

                <!-- Right Column (Sidebar Settings) -->
                <div class="space-y-6">

                    <!-- Status & Pengaturan Publikasi -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                        <h2 class="text-sm font-extrabold text-slate-800 tracking-wide">Status Publikasi</h2>

                        <!-- Visibilitas Artikel -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Visibilitas Artikel</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center justify-center gap-2 p-3 bg-emerald-50/80 border border-emerald-200 rounded-xl cursor-pointer text-xs font-bold text-slate-800">
                                    <input type="radio" name="visibility" value="published" class="text-emerald-500 focus:ring-0" checked>
                                    Published
                                </label>
                                <label class="flex items-center justify-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer text-xs font-bold text-slate-700">
                                    <input type="radio" name="visibility" value="draft" class="text-slate-500 focus:ring-0">
                                    Draft
                                </label>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="category_id"
                                id="category_id"
                                class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400"
                                required
                            >
                                <option value="" disabled selected>Pilih Kategori...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label for="tags" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                Tags (Pisahkan Koma)
                            </label>
                            <input
                                type="text"
                                name="tags"
                                id="tags"
                                value="{{ old('tags') }}"
                                placeholder="Docker, Kubernetes, DevOps"
                                class="w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                            >
                            <span class="text-[10px] text-slate-400 mt-1 block">Gunakan kata kunci relevan untuk mempermudah pencarian.</span>
                        </div>
                    </div>

                    <!-- Cover Image / Media -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                        <h2 class="text-sm font-extrabold text-slate-800 tracking-wide">Cover Image / Media</h2>

                        <!-- Preview Area -->
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center bg-slate-50/50">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs font-bold text-slate-400">Pratinjau Cover Artikel</span>
                        </div>

                        <!-- URL Gambar -->
                        <div>
                            <label for="cover_image" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">URL Gambar Cover</label>
                            <input
                                type="url"
                                name="cover_image"
                                id="cover_image"
                                value="{{ old('cover_image') }}"
                                placeholder="https://images.unsplash.com/photo-..."
                                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 text-xs placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                            >
                        </div>

                        <!-- Preset Gambar IT Populer -->
                        <div>
                            <span class="text-[11px] font-bold text-slate-500 mb-2 block">Preset Gambar IT Populer:</span>
                            <div class="grid grid-cols-4 gap-2">
                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=150" class="h-12 w-full object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity border border-slate-200">
                                <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=150" class="h-12 w-full object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity border border-slate-200">
                                <img src="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?w=150" class="h-12 w-full object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity border border-slate-200">
                                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=150" class="h-12 w-full object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity border border-slate-200">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>

<!-- Script Otomatis Slug & Jumlah Kata -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const contentTextarea = document.getElementById('content');
        const wordCountDisplay = document.getElementById('wordCount');

        // Automatic Slug Generation
        titleInput.addEventListener('input', function () {
            let slug = titleInput.value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            slugInput.value = slug;
        });

        // Word Counter
        contentTextarea.addEventListener('input', function () {
            const words = contentTextarea.value.trim().split(/\s+/).filter(word => word.length > 0);
            wordCountDisplay.textContent = words.length + ' kata';
        });
    });
</script>
@endsection
