@extends('layouts.admin')

@section('title', 'Kelola Pengguna & Role')
@section('header_title', 'Kelola Pengguna')

@section('content')
    <!-- Action Bar & Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold font-outfit text-slate-900">Manajemen Pengguna & Otorisasi Role</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kontrol hak akses pengguna (RBAC), ubah peran pengguna, serta nonaktifkan akun.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                Total: {{ $users->total() }} Pengguna Terdaftar
            </span>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
            <!-- Search Bar (8 cols) -->
            <div class="sm:col-span-8 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna..." class="block w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
            </div>

            <!-- Filter Role (3 cols) -->
            <div class="sm:col-span-3">
                <select name="role" onchange="this.form.submit()" class="block w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 text-slate-700">
                    <option value="all">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="contributor" {{ request('role') == 'contributor' ? 'selected' : '' }}>Contributor</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User Biasa</option>
                </select>
            </div>

            <!-- Action button (1 col) -->
            <div class="sm:col-span-1 flex items-center gap-1">
                <button type="submit" class="w-full flex items-center justify-center p-2 rounded-xl bg-softcyan-400 hover:bg-softcyan-500 text-slate-800 text-xs font-semibold shadow-xs transition-colors" title="Cari">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 text-xs transition-colors" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-semibold uppercase text-slate-500 tracking-wider">
                        <th class="py-3.5 px-4 sm:px-6">Pengguna</th>
                        <th class="py-3.5 px-4">Role Akses</th>
                        <th class="py-3.5 px-4">Status Akun</th>
                        <th class="py-3.5 px-4">Kontribusi Artikel</th>
                        <th class="py-3.5 px-4">Bergabung</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            
                            <!-- Avatar & Name -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-softcyan-400/20 text-softcyan-500 font-bold text-xs flex items-center justify-center border border-softcyan-400/40 flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-900 line-clamp-1 text-sm">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="ml-1 px-1.5 py-0.2 rounded text-[10px] font-bold bg-softcyan-400/20 text-softcyan-500 border border-softcyan-400/40">Anda</span>
                                            @endif
                                        </p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Changer (Inline Dropdown) -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($user->id === auth()->id())
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-softcyan-400/20 text-softcyan-500 border border-softcyan-400/40">
                                        Admin (Akun Utama)
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="px-2.5 py-1 text-xs font-semibold rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 {{ $user->role === 'admin' ? 'bg-softcyan-400/20 text-softcyan-500' : ($user->role === 'contributor' ? 'bg-softred-400/20 text-softred-500' : 'bg-slate-50 text-slate-700') }}">
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="contributor" {{ $user->role === 'contributor' ? 'selected' : '' }}>Contributor</option>
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                        </select>
                                    </form>
                                @endif
                            </td>

                            <!-- Status (Active vs Suspended) -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditangguhkan
                                    </span>
                                @endif
                            </td>

                            <!-- Articles count -->
                            <td class="py-4 px-4 whitespace-nowrap text-slate-600 font-medium text-xs">
                                {{ $user->articles_count ?? 0 }} artikel
                            </td>

                            <!-- Created Date -->
                            <td class="py-4 px-4 whitespace-nowrap text-slate-500 text-xs">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 sm:px-6 text-right whitespace-nowrap">
                                @if($user->id !== auth()->id())
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- Suspend / Activate Toggle -->
                                        <button type="button" 
                                                onclick="openConfirmModal({
                                                    title: '{{ $user->is_active ? 'Tangguhkan Pengguna' : 'Aktifkan Kembali Pengguna' }}',
                                                    message: '{{ $user->is_active ? 'Pengguna ' . addslashes($user->name) . ' tidak akan dapat masuk ke sistem sampai diaktifkan kembali.' : 'Aktifkan kembali akses login untuk ' . addslashes($user->name) . '?' }}',
                                                    action: '{{ route('admin.users.toggleStatus', $user->id) }}',
                                                    method: 'PATCH',
                                                    confirmText: '{{ $user->is_active ? 'Tangguhkan Akun' : 'Aktifkan Akun' }}',
                                                    isDestructive: {{ $user->is_active ? 'true' : 'false' }}
                                                })" 
                                                class="px-2.5 py-1 text-xs font-semibold rounded-lg border {{ $user->is_active ? 'text-amber-700 border-amber-200 hover:bg-amber-50' : 'text-emerald-700 border-emerald-200 hover:bg-emerald-50' }} transition-colors"
                                                title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                            {{ $user->is_active ? 'Suspend' : 'Aktifkan' }}
                                        </button>

                                        <!-- Delete User -->
                                        <button type="button" 
                                                onclick="openConfirmModal({
                                                    title: 'Hapus Pengguna',
                                                    message: 'Apakah Anda yakin ingin menghapus akun &ldquo;{{ addslashes($user->name) }}&rdquo; secara permanen? Seluruh data yang terkait akan terpengaruh.',
                                                    action: '{{ route('admin.users.destroy', $user->id) }}',
                                                    method: 'DELETE',
                                                    confirmText: 'Hapus Akun',
                                                    isDestructive: true
                                                })" 
                                                class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors" 
                                                title="Hapus Pengguna">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-[11px] text-slate-400 italic">Sesi Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                Tidak ada data pengguna yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 flex items-center justify-between">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
