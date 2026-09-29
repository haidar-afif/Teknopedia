<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ensiklopedia') }} @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts / Styles -->
    <!-- 1. Load CDN Tailwind terlebih dahulu -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 2. TARUH DI SINI: Konfigurasi warna kustom agar dibaca oleh CDN -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        softcyan: {
                            400: '#CCFBFA',
                            500: '#B1E5E6',
                        },
                        softred: {
                            400: '#F7ADAD',
                            500: '#F29191',
                        }
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        }
                    },
                    animation: {
                        float: 'float 5s ease-in-out infinite',
                    }
                }
            }
        }
    </script>

    <!-- Dark Mode Preference Check (to prevent FOUC) -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- 3. Load JS lokal setelah Tailwind terkonfigurasi -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 selection:bg-softcyan-400 selection:text-slate-900 flex flex-col min-h-screen transition-colors duration-300">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-softcyan-400/30 dark:border-slate-800 transition-colors duration-300">
       <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-softcyan-400 to-softcyan-500 flex items-center justify-center text-slate-800 font-bold text-lg shadow-lg shadow-softcyan-400/30 group-hover:shadow-softcyan-400/50 transition-all">T  </div>
                        <span class="font-outfit font-bold text-xl tracking-tight text-slate-800 dark:text-slate-100 transition-colors">Tekno<span class="text-softred-500">Pedia</span></span>
                    </a>
                </div>

               <!-- Search & Categories (Desktop) -->
<div class="hidden md:flex flex-1 items-center justify-center px-8 gap-6">
    <!-- Tambahkan tag <form> di sini -->
   <form action="{{ route('articles.index') }}" method="GET" class="relative w-full max-w-md group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-softcyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <!-- Tambahkan attribute name="search" dan value="{{ request('search') }}" -->
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="block w-full pl-10 pr-3 py-2 border border-slate-200 dark:border-slate-700 rounded-full leading-5 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-softcyan-400 focus:border-softcyan-400 dark:focus:bg-slate-900 focus:bg-white transition-all sm:text-sm"
            placeholder="Cari artikel, tutorial, atau error code..."
        >
    </form>
</div>

               <!-- Right Side (Login/Register / Profile) -->
<div class="hidden md:flex items-center gap-3">
    <!-- Dark Mode Toggle -->
    <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-700 rounded-lg text-sm p-2 transition-colors">
        <!-- Dark icon (Moon) -->
        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
        <!-- Light icon (Sun) -->
        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
    </button>

    @guest
        {{-- Tampilan saat BELUM login --}}
        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-softred-500 px-3 py-2 transition-colors">
            Masuk
        </a>
        <a href="{{ route('register') }}" class="text-sm font-medium bg-softcyan-400/30 text-slate-800 hover:bg-softcyan-400 px-4 py-2 rounded-full transition-colors">
            Daftar
        </a>
    @endguest

    @auth
        {{-- Tampilan saat SUDAH login --}}
        @if(Auth::user()->role === 'contributor')
            <a href="{{ route('contributor.articles.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-800 px-3 py-2">
                Dashboard Penulis
            </a>
        @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-800 px-3 py-2">
                Admin Panel
            </a>
        @endif

        <!-- Nama User -->
        <span class="text-sm font-semibold text-slate-800 px-3 py-1.5 bg-slate-100 rounded-xl">
            {{ Auth::user()->name }}
        </span>

        <!-- Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-sm font-medium text-rose-500 hover:text-rose-600 px-3 py-2 transition-colors">
                Logout
            </button>
        </form>
    @endauth
</div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-softcyan-400/30 dark:border-slate-800 mt-auto transition-colors duration-300">
        <div class="max-w-screen-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:justify-start mb-6 md:mb-0">
                    <a href="/" class="flex items-center gap-2 grayscale hover:grayscale-0 transition-all opacity-70 hover:opacity-100">
                        <div class="w-6 h-6 rounded bg-softcyan-400 flex items-center justify-center text-slate-800 font-bold text-xs">T</div>
                        <span class="font-outfit font-bold text-lg text-slate-800 dark:text-slate-200">Tekno<span class="text-softred-500">Pedia</span></span>
                    </a>
                </div>
                <div class="flex justify-center space-x-6 md:order-2 text-sm text-slate-500 dark:text-slate-400">
                    <a href="#" class="hover:text-softred-500 transition-colors">Tentang Kami</a>
                    <a href="#" class="hover:text-softred-500 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-softred-500 transition-colors">Ketentuan</a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-sm text-slate-500">
                        &copy; {{ date('Y') }} Teknopedia
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none">
        @if(session('success'))
            <div class="pointer-events-auto flex items-center gap-3 bg-softcyan-400 text-slate-800 px-4 py-3 rounded-xl shadow-xl shadow-softcyan-400/20 text-sm font-medium transition-all duration-300 transform translate-y-0 opacity-100 animate-bounce-short border border-softcyan-500">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="pointer-events-auto flex items-center gap-3 bg-softred-500 text-white px-4 py-3 rounded-xl shadow-xl shadow-softred-500/20 text-sm font-medium transition-all duration-300 transform translate-y-0 opacity-100 animate-bounce-short border border-softred-400">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Dark Mode Script -->
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
