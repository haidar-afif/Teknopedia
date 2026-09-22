<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Ensiklopedia IT') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN Script Harus Pertama -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Konfigurasi Warna Kustom Tailwind (Wajib tailwind.config) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        softcyan: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                        },
                        softred: {
                            400: '#f87171',
                            500: '#ef4444',
                        }
                    }
                }
            }
        }
    </script>

    <!-- JS Lokal (Opsional) -->
    <script src="{{ asset('js/app.js') }}"></script>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 flex overflow-hidden">

    <!-- Mobile Sidebar Backdrop -->
    <div id="mobile-sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-xs hidden transition-opacity lg:hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white text-slate-700 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:inset-auto lg:flex-shrink-0 shadow-lg border-r border-softcyan-400/30">

        <!-- Logo Area -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-softcyan-400/30 bg-slate-50/50">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-softcyan-400 to-softcyan-500 flex items-center justify-center text-slate-800 font-bold text-base shadow-md shadow-softcyan-400/20 group-hover:scale-105 transition-transform">
                    E
                </div>
                <div class="flex flex-col">
                    <span class="font-outfit font-bold text-lg tracking-tight text-slate-800 leading-tight">
                        Tekno<span class="text-softred-500">Pedia</span>
                    </span>
                    <span class="text-[10px] uppercase font-semibold text-slate-500 tracking-wider">Admin</span>
                </div>
            </a>
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden text-slate-500 hover:text-slate-800 p-1 rounded-md">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 overflow-y-auto py-5 px-3 space-y-1.5 custom-scrollbar">

            <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Navigasi Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-softcyan-400 text-slate-800 shadow-md shadow-softcyan-400/20' : 'text-slate-600 hover:text-softred-500 hover:bg-softcyan-400/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard Overview</span>
            </a>

            <!-- Content Management / CMS -->
            <div class="pt-3 pb-1 px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Manajemen Konten</div>

            <a href="{{ route('admin.content.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.content.index') ? 'bg-softcyan-400 text-slate-800 shadow-md shadow-softcyan-400/20' : 'text-slate-600 hover:text-softred-500 hover:bg-softcyan-400/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14" />
                </svg>
                <span>Kelola Artikel / CMS</span>
            </a>

            <a href="{{ route('admin.content.create') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.content.create') ? 'bg-softcyan-400 text-slate-800 shadow-md shadow-softcyan-400/20' : 'text-slate-600 hover:text-softred-500 hover:bg-softcyan-400/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Konten Baru</span>
            </a>

            <!-- System Administration -->
            <div class="pt-3 pb-1 px-3 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Administrasi Sistem</div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-softcyan-400 text-slate-800 shadow-md shadow-softcyan-400/20' : 'text-slate-600 hover:text-softred-500 hover:bg-softcyan-400/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Kelola Pengguna & Role</span>
            </a>
        </div>

        <!-- User Profile & Logout -->
        <div class="p-4 border-t border-softcyan-400/30 bg-slate-50/80">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-softred-400 flex items-center justify-center text-slate-800 font-bold text-sm shadow-sm ring-2 ring-softred-500/20">
                    {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold tracking-wide uppercase bg-softcyan-400/40 text-slate-700 border border-softcyan-400">
                            {{ auth()->user()->role ?? 'admin' }}
                        </span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-softred-500 hover:text-white hover:bg-softred-500 border border-softred-400/50 rounded-lg transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Top Header / Navbar -->
        <header class="h-16 bg-white/95 backdrop-blur-md border-b border-softcyan-400/30 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-30 flex-shrink-0">

            <div class="flex items-center gap-3">
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-softcyan-500 animate-pulse"></span>
                    <h1 class="text-lg font-outfit font-bold text-slate-800 tracking-tight">@yield('header_title', 'Admin Panel')</h1>
                </div>
            </div>

            <!-- Quick Actions & Profile -->
            <div class="flex items-center gap-3 sm:gap-5">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-softcyan-400/20 hover:bg-softcyan-400 hover:text-slate-800 transition-colors border border-softcyan-400/40 shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    <span class="hidden sm:inline">Lihat Website</span>
                    <span class="sm:hidden">Web</span>
                </a>

                <!-- Notification Bell Indicator -->
                <div class="relative">
                    <button type="button" class="p-2 text-slate-500 hover:text-softred-500 hover:bg-softred-400/10 rounded-lg relative transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-softred-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-softred-500"></span>
                        </span>
                    </button>
                </div>

                <!-- Admin Badge -->
                <div class="flex items-center gap-2 pl-2 border-l border-softcyan-400/40">
                    <div class="w-8 h-8 rounded-full bg-softred-400 text-slate-800 font-bold text-xs flex items-center justify-center shadow-xs">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-xs font-semibold text-slate-800 leading-none">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <span class="text-[10px] text-slate-500 font-medium">Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Viewport -->
        <main class="flex-1 overflow-y-auto bg-slate-50/70 custom-scrollbar focus:outline-none">
            <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Reusable Confirmation Dialog Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs transition-opacity" onclick="closeConfirmModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-softcyan-400/30">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="modal-icon-container" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-softred-400/20 sm:mx-0 sm:h-10 sm:w-10 text-softred-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-semibold text-slate-800 font-outfit" id="modal-title">Konfirmasi Tindakan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-600" id="modal-message">Apakah Anda yakin ingin melanjutkan tindakan ini? Data yang dihapus tidak dapat dipulihkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-3.5 sm:flex sm:flex-row-reverse gap-2 border-t border-slate-100">
                    <form id="modal-confirm-form" method="POST" action="">
                        @csrf
                        <input type="hidden" name="_method" id="modal-form-method" value="POST">
                        <button type="submit" id="modal-confirm-btn" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-softred-500 text-sm font-semibold text-white hover:bg-softred-400 focus:outline-none transition-colors sm:w-auto">
                            Ya, Lanjutkan
                        </button>
                    </form>
                    <button type="button" onclick="closeConfirmModal()" class="mt-2 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-xs px-4 py-2 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none transition-colors sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 pointer-events-none max-w-sm w-full">
        @if(session('success'))
            <div class="pointer-events-auto flex items-center gap-3 bg-softcyan-400 text-slate-800 px-4 py-3.5 rounded-xl shadow-lg shadow-softcyan-400/20 text-sm font-medium transition-all duration-300 transform translate-y-0 opacity-100 border border-softcyan-500">
                <svg class="w-5 h-5 flex-shrink-0 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <div class="flex-1">{{ session('success') }}</div>
                <button onclick="this.parentElement.remove()" class="text-slate-600 hover:text-slate-800"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
        @endif
        @if(session('error'))
            <div class="pointer-events-auto flex items-center gap-3 bg-softred-500 text-white px-4 py-3.5 rounded-xl shadow-lg shadow-softred-500/20 text-sm font-medium transition-all duration-300 transform translate-y-0 opacity-100 border border-softred-400">
                <svg class="w-5 h-5 flex-shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <div class="flex-1">{{ session('error') }}</div>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-slate-200"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
        @endif
    </div>

    <!-- Global Admin UI Scripts -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function openConfirmModal(options) {
            const modal = document.getElementById('confirm-modal');
            const title = document.getElementById('modal-title');
            const message = document.getElementById('modal-message');
            const form = document.getElementById('modal-confirm-form');
            const methodInput = document.getElementById('modal-form-method');
            const confirmBtn = document.getElementById('modal-confirm-btn');

            title.innerText = options.title || 'Konfirmasi Tindakan';
            message.innerText = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            form.action = options.action || '#';
            methodInput.value = options.method ? options.method.toUpperCase() : 'POST';

            confirmBtn.innerText = options.confirmText || 'Ya, Lanjutkan';

            if (options.isDestructive === false) {
                confirmBtn.className = "w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-softcyan-400 text-sm font-semibold text-slate-800 hover:bg-softcyan-500 focus:outline-none transition-colors sm:w-auto";
            } else {
                confirmBtn.className = "w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-softred-500 text-sm font-semibold text-white hover:bg-softred-400 focus:outline-none transition-colors sm:w-auto";
            }

            modal.classList.remove('hidden');
        }

        function closeConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
        }

        // Close modal on Escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeConfirmModal();
            }
        });

        // Dynamic Toast Dispatcher
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const bgClass = type === 'success' ? 'bg-softcyan-400 border-softcyan-500 text-slate-800' : (type === 'error' ? 'bg-softred-500 border-softred-400 text-white' : 'bg-slate-200 text-slate-800');

            toast.className = `pointer-events-auto flex items-center gap-3 ${bgClass} px-4 py-3.5 rounded-xl shadow-lg text-sm font-medium transition-all duration-300 transform translate-y-2 opacity-0 border`;
            toast.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto opacity-70 hover:opacity-100">&times;</button>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        };

        // Auto dismiss session toasts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('#toast-container > div').forEach(el => {
                el.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
