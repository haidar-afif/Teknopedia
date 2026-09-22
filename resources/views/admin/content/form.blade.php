@extends('layouts.admin')

@section('title', $isEdit ? 'Sunting Artikel - ' . $article->title : 'Tulis Artikel Baru')
@section('header_title', $isEdit ? 'Sunting Artikel' : 'Tulis Artikel Baru')

@section('content')
    <form id="article-form" method="POST" action="{{ $isEdit ? route('admin.content.update', $article->id) : route('admin.content.store') }}" class="space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <input type="hidden" name="status" id="status-input" value="{{ old('status', $article->status ?? 'published') }}">

        <!-- Top Action Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200/80">
            <div>
                <a href="{{ route('admin.content.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-softred-500 transition-colors mb-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke Daftar Artikel
                </a>
                <h2 class="text-xl sm:text-2xl font-bold font-outfit text-slate-900">
                    {{ $isEdit ? 'Sunting Artikel' : 'Buat Artikel Baru' }}
                </h2>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap">
                <!-- Batal Button -->
                <button type="button" onclick="confirmCancel()" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 transition-colors shadow-xs">
                    Batal
                </button>

                <!-- Simpan Draft Button -->
                <button type="button" onclick="submitWithStatus('draft')" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 transition-colors shadow-xs">
                    Simpan Draft
                </button>

                <!-- Publikasikan Button -->
                <button type="button" onclick="submitWithStatus('published')" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-800 bg-softcyan-400 hover:bg-softcyan-500 shadow-md shadow-softcyan-400/20 transition-all hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <span>{{ $isEdit ? 'Simpan Perubahan' : 'Publikasikan Sekarang' }}</span>
                </button>
            </div>
        </div>

        <!-- Validation Errors Alert -->
        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <div class="font-bold flex items-center gap-1.5 mb-1 text-sm">
                    <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Terdapat kesalahan input formulir:
                </div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left 2 Cols: Main Editor & Title -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Title & Slug Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <div>
                        <label for="title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Judul Artikel <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" placeholder="Contoh: Arsitektur Microservices Modern dengan Docker & Kubernetes" required oninput="generateSlug(this.value)" class="block w-full px-4 py-2.5 text-sm sm:text-base font-medium border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
                    </div>
                </div>

                <!-- Rich Text / Markdown Editor -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">

                    <!-- Editor Tabs & Toolbar -->
                    <div class="border-b border-slate-200/80 bg-slate-50/80 px-4 py-2.5 flex flex-wrap items-center justify-between gap-2">
                        <!-- Mode Tabs -->
                        <div class="flex items-center bg-slate-200/70 p-0.5 rounded-lg text-xs font-medium">
                            <button type="button" id="tab-write-btn" onclick="switchEditorTab('write')" class="px-3 py-1 rounded-md bg-white text-softred-500 shadow-xs">Tulis Konten</button>
                            <button type="button" id="tab-preview-btn" onclick="switchEditorTab('preview')" class="px-3 py-1 rounded-md text-slate-600 hover:text-slate-900">Live Preview</button>
                        </div>

                        <!-- Markdown Toolbar Buttons -->
                        <div id="editor-toolbar" class="flex items-center gap-1 flex-wrap">
                            <button type="button" onclick="insertSyntax('**', '**', 'teks tebal')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600 hover:text-slate-900" title="Tebal (Bold)"><strong class="font-bold">B</strong></button>
                            <button type="button" onclick="insertSyntax('*', '*', 'teks miring')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600 hover:text-slate-900" title="Miring (Italic)"><em class="italic font-serif">I</em></button>
                            <span class="w-px h-4 bg-slate-300 mx-1"></span>
                            <button type="button" onclick="insertSyntax('## ', '', 'Judul Bagian')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600 text-xs font-bold" title="Heading 2">H2</button>
                            <button type="button" onclick="insertSyntax('### ', '', 'Sub-Judul')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600 text-xs font-bold" title="Heading 3">H3</button>
                            <span class="w-px h-4 bg-slate-300 mx-1"></span>
                            <button type="button" onclick="insertSyntax('```bash\n', '\n```', 'echo Hello World')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600" title="Code Snippet">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                            </button>
                            <button type="button" onclick="insertSyntax('- ', '', 'Item daftar')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600" title="Daftar (List)">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            </button>
                            <button type="button" onclick="insertSyntax('> ', '', 'Kutipan penting')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600 text-xs font-serif font-bold" title="Quote">&ldquo;</button>
                            <button type="button" onclick="insertSyntax('[', '](https://example.com)', 'Tautan')" class="p-1.5 rounded hover:bg-slate-200 text-slate-600" title="Link Tautan">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Editor Textarea -->
                    <div id="editor-write-view" class="p-4">
                        <textarea name="content" id="content" rows="18" placeholder="Tulis isi artikel dengan format Markdown atau teks terstruktur..." required class="w-full text-sm font-mono leading-relaxed border-0 focus:ring-0 focus:outline-none resize-y text-slate-800 placeholder-slate-400 min-h-[380px]">{{ old('content', $article->content) }}</textarea>
                    </div>

                    <!-- Editor Live Preview Tab -->
                    <div id="editor-preview-view" class="p-6 hidden min-h-[420px] prose prose-slate max-w-none bg-white">
                        <div id="preview-content-rendered" class="text-sm leading-relaxed text-slate-700">
                            <!-- Rendered by simple JS markdown converter -->
                        </div>
                    </div>

                    <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Format: Markdown Didukung</span>
                        <span id="word-count">0 kata</span>
                    </div>
                </div>

            </div>

            <!-- Right 1 Col: Metadata & Media -->
            <div class="space-y-5">

                <!-- Status & Publish Setting -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <h3 class="font-outfit font-bold text-sm text-slate-900 border-b border-slate-100 pb-2">Status Publikasi</h3>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Visibilitas Artikel</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-softcyan-500 has-[:checked]:bg-softcyan-400/20">
                                <input type="radio" name="ui_status" value="published" onchange="document.getElementById('status-input').value='published'" {{ old('status', $article->status ?? 'published') === 'published' ? 'checked' : '' }} class="text-softcyan-500 focus:ring-softcyan-400">
                                <span class="text-xs font-semibold text-slate-800">Published</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/40">
                                <input type="radio" name="ui_status" value="draft" onchange="document.getElementById('status-input').value='draft'" {{ old('status', $article->status) === 'draft' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                                <span class="text-xs font-semibold text-slate-800">Draft</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="category_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                        <select name="category_id" id="category_id" required class="block w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 text-slate-700">
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tags" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Tags (Pisahkan koma)</label>
                        <input type="text" name="tags" id="tags" value="{{ old('tags', $article->tags) }}" placeholder="Docker, Kubernetes, DevOps" class="block w-full px-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400">
                        <p class="text-[10px] text-slate-400 mt-1">Gunakan kata kunci relevan untuk mempermudah pencarian.</p>
                    </div>
                </div>

                <!-- Cover Image & Media Selector -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <h3 class="font-outfit font-bold text-sm text-slate-900 border-b border-slate-100 pb-2">Cover Image / Media</h3>

                    <!-- Image Preview Box -->
                    <div class="relative w-full h-36 rounded-xl bg-slate-100 border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center group">
                        <img id="cover-preview-img" src="{{ old('cover_image', $article->cover_image) }}" alt="Preview Cover" class="w-full h-full object-cover {{ old('cover_image', $article->cover_image) ? '' : 'hidden' }}">
                        <div id="cover-placeholder" class="text-center p-3 {{ old('cover_image', $article->cover_image) ? 'hidden' : '' }}">
                            <svg class="mx-auto h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <p class="text-[11px] text-slate-500 font-medium mt-1">Pratinjau Cover Artikel</p>
                        </div>
                    </div>

                    <!-- URL Input -->
                    <div>
                        <label for="cover_image" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">URL Gambar Cover</label>
                        <input type="url" name="cover_image" id="cover_image" value="{{ old('cover_image', $article->cover_image) }}" oninput="updateCoverPreview(this.value)" placeholder="https://images.unsplash.com/photo-..." class="block w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400">
                    </div>

                    <!-- Quick Preset Tech Images -->
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500 mb-1.5">Preset Gambar IT Populer:</p>
                        <div class="grid grid-cols-4 gap-1.5">
                            <button type="button" onclick="selectPresetImage('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80')" class="h-10 rounded-lg overflow-hidden border border-slate-200 hover:border-softcyan-400 focus:outline-none transition-all">
                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover">
                            </button>
                            <button type="button" onclick="selectPresetImage('https://images.unsplash.com/photo-1544383835-bda2bc66a55d?auto=format&fit=crop&w=1200&q=80')" class="h-10 rounded-lg overflow-hidden border border-slate-200 hover:border-softcyan-400 focus:outline-none transition-all">
                                <img src="https://images.unsplash.com/photo-1544383835-bda2bc66a55d?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover">
                            </button>
                            <button type="button" onclick="selectPresetImage('https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?auto=format&fit=crop&w=1200&q=80')" class="h-10 rounded-lg overflow-hidden border border-slate-200 hover:border-softcyan-400 focus:outline-none transition-all">
                                <img src="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover">
                            </button>
                            <button type="button" onclick="selectPresetImage('https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80')" class="h-10 rounded-lg overflow-hidden border border-slate-200 hover:border-softcyan-400 focus:outline-none transition-all">
                                <img src="https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover">
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </form>

    @push('scripts')
    <script>
        // Auto Generate Slug
        function generateSlug(val) {
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slug-preview');
            const slugified = val.toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slugified;
            slugPreview.innerText = slugified || 'judul-artikel';
        }

        // Cover Preview
        function updateCoverPreview(url) {
            const img = document.getElementById('cover-preview-img');
            const placeholder = document.getElementById('cover-placeholder');
            if (url.trim() !== '') {
                img.src = url;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        function selectPresetImage(url) {
            document.getElementById('cover_image').value = url;
            updateCoverPreview(url);
        }

        // Editor Syntax Insertion
        function insertSyntax(prefix, suffix, placeholder) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const selectedText = text.substring(start, end) || placeholder;
            const replacement = prefix + selectedText + suffix;

            textarea.value = text.substring(0, start) + replacement + text.substring(end);
            textarea.focus();
            textarea.selectionStart = start + prefix.length;
            textarea.selectionEnd = start + prefix.length + selectedText.length;
            updateWordCount();
        }

        // Editor Tabs Switch
        function switchEditorTab(mode) {
            const writeView = document.getElementById('editor-write-view');
            const previewView = document.getElementById('editor-preview-view');
            const writeBtn = document.getElementById('tab-write-btn');
            const previewBtn = document.getElementById('tab-preview-btn');
            const toolbar = document.getElementById('editor-toolbar');

            if (mode === 'preview') {
                writeView.classList.add('hidden');
                previewView.classList.remove('hidden');
                toolbar.classList.add('opacity-40', 'pointer-events-none');

                writeBtn.className = "px-3 py-1 rounded-md text-slate-600 hover:text-slate-900";
                previewBtn.className = "px-3 py-1 rounded-md bg-white text-softred-500 shadow-xs";

                renderMarkdownPreview();
            } else {
                writeView.classList.remove('hidden');
                previewView.classList.add('hidden');
                toolbar.classList.remove('opacity-40', 'pointer-events-none');

                writeBtn.className = "px-3 py-1 rounded-md bg-white text-softred-500 shadow-xs";
                previewBtn.className = "px-3 py-1 rounded-md text-slate-600 hover:text-slate-900";
            }
        }

        function renderMarkdownPreview() {
            const raw = document.getElementById('content').value;
            const target = document.getElementById('preview-content-rendered');

            // Simple markdown parser for preview
            let html = raw
                .replace(/^### (.*$)/gim, '<h3 class="text-base font-bold text-slate-900 mt-4 mb-2">$1</h3>')
                .replace(/^## (.*$)/gim, '<h2 class="text-lg font-bold text-slate-900 mt-5 mb-2 pb-1 border-b border-slate-100">$1</h2>')
                .replace(/^# (.*$)/gim, '<h1 class="text-xl font-bold text-slate-900 mt-6 mb-3">$1</h1>')
                .replace(/^\> (.*$)/gim, '<blockquote class="border-l-4 border-softcyan-500 pl-4 py-1 italic text-slate-600 my-3 bg-slate-50 rounded-r">$1</blockquote>')
                .replace(/\*\*(.*?)\*\*/gim, '<strong class="font-bold text-slate-900">$1</strong>')
                .replace(/\*(.*?)\*/gim, '<em class="italic">$1</em>')
                .replace(/```([\s\S]*?)```/gim, '<pre class="bg-slate-900 text-slate-100 p-4 rounded-xl text-xs font-mono my-3 overflow-x-auto"><code>$1</code></pre>')
                .replace(/`([^`]+)`/gim, '<code class="bg-slate-100 text-softred-500 px-1.5 py-0.5 rounded text-xs font-mono">$1</code>')
                .replace(/^\- (.*$)/gim, '<li class="ml-4 list-disc text-slate-700">$1</li>')
                .replace(/\[(.*?)\]\((.*?)\)/gim, '<a href="$2" target="_blank" class="text-softcyan-500 hover:underline">$1</a>')
                .replace(/\n\n/gim, '<br><br>');

            target.innerHTML = html || '<p class="text-slate-400 italic">Belum ada konten ditulis...</p>';
        }

        function updateWordCount() {
            const text = document.getElementById('content').value.trim();
            const words = text ? text.split(/\s+/).length : 0;
            document.getElementById('word-count').innerText = words + ' kata';
        }

        document.getElementById('content').addEventListener('input', updateWordCount);
        updateWordCount();

        // Submit With Status
        function submitWithStatus(status) {
            document.getElementById('status-input').value = status;
            document.getElementById('article-form').submit();
        }

        // Confirm Cancel Dialog
        function confirmCancel() {
            openConfirmModal({
                title: 'Batalkan Pengeditan?',
                message: 'Perubahan yang belum disimpan akan hilang. Apakah Anda yakin ingin kembali ke daftar artikel?',
                confirmText: 'Ya, Tinggalkan Halaman',
                action: '{{ route('admin.content.index') }}',
                method: 'GET',
                isDestructive: false
            });
            // override form submit action to redirect
            document.getElementById('modal-confirm-form').onsubmit = function(e) {
                e.preventDefault();
                window.location.href = '{{ route('admin.content.index') }}';
            };
        }
    </script>
    @endpush
@endsection
