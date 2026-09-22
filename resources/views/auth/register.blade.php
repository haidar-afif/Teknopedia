@extends('layouts.app')

@section('title', '- Daftar Penulis Baru')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl border border-slate-100 shadow-xl shadow-slate-100">
        <div>
            <div class="w-12 h-12 rounded-xl bg-softcyan-400 flex items-center justify-center font-bold text-slate-800 text-xl mx-auto mb-3">T</div>
            <h2 class="text-center text-2xl font-bold text-slate-800 font-outfit">
                Daftar Akun Penulis
            </h2>
            <p class="mt-2 text-center text-sm text-slate-500">
                Bergabunglah sebagai kontributor di TeknoPedia dan bagikan wawasanmu!
            </p>
        </div>

        <form class="mt-8 space-y-5" action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input id="name" name="name" type="text" required value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 rounded-xl border @error('name') border-rose-500 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-softcyan-400 transition-colors"
                    placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-softcyan-400 transition-colors"
                    placeholder="nama@email.com">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full px-4 py-2.5 rounded-xl border @error('password') border-rose-500 @else border-slate-200 @enderror text-sm focus:outline-none focus:border-softcyan-400 transition-colors"
                    placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-softcyan-400 transition-colors"
                    placeholder="Ulangi password di atas">
            </div>

            <!-- Tombol Register -->
            <div>
                <button type="submit"
                    class="w-full py-3 px-4 rounded-xl text-sm font-semibold text-slate-800 bg-softcyan-400 hover:bg-softcyan-500 transition-all shadow-md shadow-softcyan-400/20">
                    Daftar Sekarang
                </button>
            </div>
        </form>

        <div class="text-center pt-2">
            <p class="text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-softred-500 hover:text-softred-600">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
