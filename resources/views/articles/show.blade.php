@extends('layouts.app')

@section('title', '- ' . $article->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 flex flex-col lg:flex-row gap-8 items-start">
    
    <!-- Left Sidebar: Table of Contents -->
    <aside id="toc-sidebar" class="hidden lg:block w-full lg:w-64 flex-shrink-0 sticky top-24 transition-all duration-300">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-outfit font-bold text-slate-800 dark:text-slate-200 text-lg">Daftar Isi</h3>
                <button id="toc-toggle" class="text-slate-500 hover:text-softred-500 transition-colors text-sm font-medium">Sembunyikan</button>
            </div>
            <nav id="toc-nav" class="space-y-1 text-sm max-h-[calc(100vh-200px)] overflow-y-auto pr-2 custom-scrollbar transition-all duration-300">
                <!-- TOC items will be injected here via JS -->
            </nav>
        </div>
    </aside>

    <!-- Middle Content: Article -->
    <div id="article-container" class="flex-1 max-w-3xl w-full transition-all duration-300">
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
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-slate-100 font-outfit leading-tight mb-6">
            {{ $article->title }}
        </h1>
        
        <div class="flex flex-wrap items-center gap-y-4 gap-x-6 text-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-softcyan-400/20 flex items-center justify-center text-softcyan-500 font-bold border border-softcyan-400/40">
                    {{ strtoupper(substr($article->author->name ?? 'Admin', 0, 2)) }}
                </div>
                <div>
                    <p class="font-medium text-slate-900 dark:text-slate-200">{{ $article->author->name ?? 'Admin' }}</p>
                    <p class="text-slate-500 dark:text-slate-400">{{ ucfirst($article->author->role ?? 'Contributor') }}</p>
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
    <article id="prose-content" class="prose prose-slate dark:prose-invert max-w-none prose-headings:font-outfit prose-a:text-softcyan-500 hover:prose-a:text-softcyan-600 prose-img:rounded-xl transition-all duration-300">
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
    
    <!-- Right Sidebar: Pengaturan Tampilan -->
    <aside id="settings-sidebar" class="hidden lg:block w-full lg:w-64 flex-shrink-0 sticky top-24 transition-all duration-300">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-outfit font-bold text-slate-800 dark:text-slate-200 text-lg">Tampilan</h3>
                <button id="settings-toggle" class="text-slate-500 hover:text-softred-500 transition-colors text-sm font-medium">Sembunyi</button>
            </div>
            
            <div id="settings-panel" class="space-y-6 text-sm transition-all duration-300 overflow-hidden">
                <!-- Teks -->
                <div>
                    <span class="block font-medium text-slate-700 dark:text-slate-300 mb-2">Ukuran Teks</span>
                    <div class="flex gap-2">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="text-size" value="prose-sm" class="peer sr-only">
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all text-xs font-medium">Kecil</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="text-size" value="prose-base" class="peer sr-only" checked>
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all text-sm font-medium">Standar</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="text-size" value="prose-lg" class="peer sr-only">
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all text-base font-medium">Besar</div>
                        </label>
                    </div>
                </div>

                <!-- Lebar -->
                <div>
                    <span class="block font-medium text-slate-700 dark:text-slate-300 mb-2">Lebar Konten</span>
                    <div class="flex gap-2">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="width-size" value="max-w-3xl" class="peer sr-only" checked>
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all font-medium">Standar</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="width-size" value="max-w-5xl" class="peer sr-only">
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all font-medium">Lebar</div>
                        </label>
                    </div>
                </div>

                <!-- Warna (Tema) -->
                <div>
                    <span class="block font-medium text-slate-700 dark:text-slate-300 mb-2">Tema Warna</span>
                    <div class="flex gap-2">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="theme-color" value="auto" class="peer sr-only">
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all font-medium">Auto</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="theme-color" value="light" class="peer sr-only">
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all font-medium">Terang</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="theme-color" value="dark" class="peer sr-only">
                            <div class="text-center px-2 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 peer-checked:border-softcyan-500 peer-checked:bg-softcyan-50 dark:peer-checked:bg-softcyan-900/20 peer-checked:text-softcyan-600 dark:peer-checked:text-softcyan-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all font-medium">Gelap</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const article = document.querySelector('.prose');
        const tocNav = document.getElementById('toc-nav');
        const tocToggle = document.getElementById('toc-toggle');
        const tocSidebar = document.getElementById('toc-sidebar');
        
        if (!article || !tocNav) return;

        const headings = article.querySelectorAll('h2, h3');
        if (headings.length === 0) {
            tocSidebar.classList.add('hidden');
            tocSidebar.classList.remove('lg:block');
            return;
        }

        headings.forEach((heading, index) => {
            // Assign ID to heading if it doesn't have one
            if (!heading.id) {
                heading.id = 'heading-' + index;
            }

            const link = document.createElement('a');
            link.href = '#' + heading.id;
            link.textContent = heading.textContent;
            link.className = 'block py-1.5 transition-colors hover:text-softcyan-500 dark:hover:text-softcyan-400 toc-link text-slate-600 dark:text-slate-400';
            
            if (heading.tagName.toLowerCase() === 'h3') {
                link.classList.add('pl-4', 'text-sm');
            } else {
                link.classList.add('font-medium');
            }

            link.dataset.target = heading.id;
            
            // Smooth scrolling logic
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById(this.dataset.target);
                if (target) {
                    const headerOffset = 100; // Account for sticky navbar
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.scrollY - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            });

            tocNav.appendChild(link);
        });

        // Intersection Observer for active state
        const observerOptions = {
            root: null,
            rootMargin: '-100px 0px -60% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Remove active from all
                    document.querySelectorAll('.toc-link').forEach(link => {
                        link.classList.remove('text-softcyan-500', 'dark:text-softcyan-400', 'font-bold');
                        link.classList.add('text-slate-600', 'dark:text-slate-400');
                    });
                    
                    // Add active to current
                    const activeLink = document.querySelector(`.toc-link[data-target="${entry.target.id}"]`);
                    if (activeLink) {
                        activeLink.classList.remove('text-slate-600', 'dark:text-slate-400');
                        activeLink.classList.add('text-softcyan-500', 'dark:text-softcyan-400', 'font-bold');
                    }
                }
            });
        }, observerOptions);

        headings.forEach(heading => observer.observe(heading));

        // Toggle functionality for TOC
        if (tocToggle) {
            let isHidden = false;
            tocToggle.addEventListener('click', () => {
                isHidden = !isHidden;
                if (isHidden) {
                    tocNav.style.maxHeight = '0px';
                    tocNav.style.opacity = '0';
                    tocNav.style.overflow = 'hidden';
                    tocToggle.textContent = 'Tampilkan';
                } else {
                    tocNav.style.maxHeight = '500px';
                    tocNav.style.opacity = '1';
                    tocNav.style.overflow = 'auto';
                    tocToggle.textContent = 'Sembunyikan';
                }
            });
        }
        
        // --- Appearance Settings Logic ---
        
        // Toggle functionality for Settings
        const settingsToggle = document.getElementById('settings-toggle');
        const settingsPanel = document.getElementById('settings-panel');
        if (settingsToggle) {
            let isSettingsHidden = false;
            settingsToggle.addEventListener('click', () => {
                isSettingsHidden = !isSettingsHidden;
                if (isSettingsHidden) {
                    settingsPanel.style.maxHeight = '0px';
                    settingsPanel.style.opacity = '0';
                    settingsToggle.textContent = 'Tampil';
                } else {
                    settingsPanel.style.maxHeight = '500px';
                    settingsPanel.style.opacity = '1';
                    settingsToggle.textContent = 'Sembunyi';
                }
            });
        }

        // Apply Text Size
        const proseContent = document.getElementById('prose-content');
        const textRadios = document.querySelectorAll('input[name="text-size"]');
        textRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                proseContent.classList.remove('prose-sm', 'prose-base', 'prose-lg');
                if (e.target.value !== 'prose-base') {
                    proseContent.classList.add(e.target.value);
                }
            });
        });

        // Apply Width Size
        const articleContainer = document.getElementById('article-container');
        const widthRadios = document.querySelectorAll('input[name="width-size"]');
        widthRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                articleContainer.classList.remove('max-w-3xl', 'max-w-5xl');
                articleContainer.classList.add(e.target.value);
            });
        });

        // Apply Theme Color
        const themeRadios = document.querySelectorAll('input[name="theme-color"]');
        
        // set initial checked based on localStorage or auto
        let currentTheme = localStorage.getItem('color-theme');
        if (currentTheme === 'dark') {
            document.querySelector('input[name="theme-color"][value="dark"]').checked = true;
        } else if (currentTheme === 'light') {
            document.querySelector('input[name="theme-color"][value="light"]').checked = true;
        } else {
            document.querySelector('input[name="theme-color"][value="auto"]').checked = true;
        }

        themeRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                const val = e.target.value;
                if (val === 'dark') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else if (val === 'light') {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else if (val === 'auto') {
                    localStorage.removeItem('color-theme');
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
                
                // Keep the top navbar theme-toggle icons in sync
                const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
                const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
                if (themeToggleDarkIcon && themeToggleLightIcon) {
                    if (document.documentElement.classList.contains('dark')) {
                        themeToggleLightIcon.classList.remove('hidden');
                        themeToggleDarkIcon.classList.add('hidden');
                    } else {
                        themeToggleDarkIcon.classList.remove('hidden');
                        themeToggleLightIcon.classList.add('hidden');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
