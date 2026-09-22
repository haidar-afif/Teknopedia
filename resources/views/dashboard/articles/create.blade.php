@extends('layouts.dashboard')

@section('header', 'Tulis Artikel Baru')

@section('content')
<div class="mb-6">
    <a href="/dashboard" class="text-sm font-medium text-slate-500 hover:text-indigo-600 flex items-center gap-1 transition-colors w-fit">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Daftar Artikel
    </a>
</div>

<div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden">
    <form action="#" method="POST" class="p-6 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kolom Kiri: Form Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" id="title" name="title" class="block w-full px-4 py-3 border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-medium transition-all" placeholder="Misal: Membangun API Cepat dengan Laravel 11">
                </div>
                
                <!-- Slug (Otomatis biasanya) -->
                <div>
                    <label for="slug" class="block text-sm font-bold text-slate-700 mb-2">Slug (URL)</label>
                    <div class="flex rounded-lg shadow-sm">
                        <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500 sm:text-sm">
                            ensiklopedia.it/artikel/
                        </span>
                        <input type="text" id="slug" name="slug" class="flex-1 block w-full px-4 py-2 border border-slate-300 rounded-r-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all bg-slate-50/50" placeholder="membangun-api-cepat-dengan-laravel-11">
                    </div>
                </div>

                <!-- Konten Editor -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="content" class="block text-sm font-bold text-slate-700">Konten Artikel <span class="text-rose-500">*</span></label>
                        <button type="button" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Insert Image
                        </button>
                    </div>
                    
                    <!-- Simple Toolbar for mock -->
                    <div class="border border-slate-300 border-b-0 rounded-t-lg bg-slate-50 p-2 flex flex-wrap gap-1">
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded"><strong class="font-serif">B</strong></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded"><em class="font-serif">I</em></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded underline font-serif">U</button>
                        <div class="w-px h-6 bg-slate-300 mx-1 self-center"></div>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded text-sm font-mono">&lt;/&gt;</button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded text-sm font-serif">H2</button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded text-sm font-serif">H3</button>
                        <div class="w-px h-6 bg-slate-300 mx-1 self-center"></div>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-slate-200 hover:text-slate-700 rounded">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        </button>
                    </div>
                    <textarea id="content" name="content" rows="15" class="block w-full p-4 border border-slate-300 rounded-b-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-mono leading-relaxed resize-y" placeholder="Tulis konten artikel Anda di sini... Mendukung format Markdown."></textarea>
                </div>
            </div>

            <!-- Kolom Kanan: Pengaturan -->
            <div class="space-y-6">
                <!-- Cover Image -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                    <h3 class="text-sm font-bold text-slate-900 mb-3">Cover Artikel</h3>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-indigo-400 hover:bg-indigo-50/50 transition-colors cursor-pointer group">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload file</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, WEBP max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Kategori & Tag -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 space-y-4">
                    <div>
                        <label for="category" class="block text-sm font-bold text-slate-900 mb-2">Kategori <span class="text-rose-500">*</span></label>
                        <select id="category" name="category" class="block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                            <option value="" disabled selected>Pilih Kategori...</option>
                            <option value="1">Web Dev</option>
                            <option value="2">Backend</option>
                            <option value="3">Hardware/IoT</option>
                            <option value="4">Git & DevOps</option>
                        </select>
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-bold text-slate-900 mb-2">Tags</label>
                        <input type="text" id="tags" name="tags" class="block w-full px-4 py-2 border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all" placeholder="Bisa lebih dari 1, pisahkan koma">
                        <p class="mt-1.5 text-xs text-slate-500">Contoh: Laravel, API, Tutorial</p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="pt-4 border-t border-slate-200">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        Publish Artikel
                    </button>
                    <button type="button" class="mt-3 w-full flex justify-center py-3 px-4 border border-slate-300 rounded-lg shadow-sm text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        Simpan sebagai Draft
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection
