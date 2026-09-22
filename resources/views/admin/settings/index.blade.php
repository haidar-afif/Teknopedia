@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('header_title', 'Pengaturan Website')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200/80">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold font-outfit text-slate-900">Konfigurasi Situs & Metadata</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Atur identitas umum, logo, kontak resmi, dan optimasi mesin pencari (SEO).</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left 2 Cols: Form Sections -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Section 1: Identitas & SEO -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-softcyan-400/20 text-softcyan-500 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-bold text-base text-slate-900">Identitas Situs & SEO</h3>
                            <p class="text-xs text-slate-400">Informasi utama yang terbaca oleh pengunjung dan mesin pencari (Google)</p>
                        </div>
                    </div>

                    <div>
                        <label for="site_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nama Website <span class="text-rose-500">*</span></label>
                        <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Ensiklopedia IT') }}" required oninput="updateSeoPreview()" class="block w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
                    </div>

                    <div>
                        <label for="site_tagline" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Tagline / Slogan</label>
                        <input type="text" name="site_tagline" id="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" oninput="updateSeoPreview()" placeholder="Pusat Pengetahuan & Dokumentasi Teknologi Informasi Indonesia" class="block w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
                    </div>

                    <div>
                        <label for="meta_description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Meta Description (SEO)</label>
                        <textarea name="meta_description" id="meta_description" rows="3" oninput="updateSeoPreview()" placeholder="Deskripsi ringkas mengenai platform untuk hasil pencarian Google..." class="block w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all resize-y">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Disarankan antara 120 - 160 karakter agar optimal di SERP.</p>
                    </div>
                </div>

                <!-- Section 2: Informasi Kontak -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-bold text-base text-slate-900">Informasi Kontak & Redaksi</h3>
                            <p class="text-xs text-slate-400">Saluran komunikasi yang ditampilkan pada footer dan halaman kontak</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="contact_email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Email Resmi</label>
                            <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" placeholder="redaksi@ensiklopedia.it" class="block w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">No. Telepon / WhatsApp</label>
                            <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" placeholder="+62 812-3456-7890" class="block w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="contact_address" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Kantor / Komunitas</label>
                        <input type="text" name="contact_address" id="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}" placeholder="Jl. Jenderal Sudirman, Jakarta Selatan" class="block w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400 transition-all">
                    </div>
                </div>

                <!-- Section 3: Media Sosial -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-bold text-base text-slate-900">Tautan Media Sosial</h3>
                            <p class="text-xs text-slate-400">Hubungkan komunitas dengan platform pengembang resmi</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label for="social_github" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">GitHub Organization</label>
                            <div class="relative rounded-xl shadow-xs">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs font-mono">github.com/</span>
                                <input type="text" name="social_github" id="social_github" value="{{ old('social_github', $settings['social_github'] ?? '') }}" placeholder="ensiklopedia-it" class="block w-full pl-24 pr-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400">
                            </div>
                        </div>

                        <div>
                            <label for="social_twitter" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Twitter / X</label>
                            <div class="relative rounded-xl shadow-xs">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs font-mono">x.com/</span>
                                <input type="text" name="social_twitter" id="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" placeholder="ensiklopedia_it" class="block w-full pl-16 pr-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400">
                            </div>
                        </div>

                        <div>
                            <label for="social_linkedin" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">LinkedIn Page</label>
                            <div class="relative rounded-xl shadow-xs">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs font-mono">linkedin.com/</span>
                                <input type="text" name="social_linkedin" id="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" placeholder="company/ensiklopedia-it" class="block w-full pl-28 pr-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right 1 Col: Visual Branding & SEO Preview -->
            <div class="space-y-6">
                
                <!-- Branding Visual (Logo & Favicon) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                    <h3 class="font-outfit font-bold text-sm text-slate-900 border-b border-slate-100 pb-2">Logo & Favicon</h3>

                    <!-- Logo Setting -->
                    <div>
                        <label for="site_logo" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Logo URL</label>
                        <input type="url" name="site_logo" id="site_logo" value="{{ old('site_logo', $settings['site_logo'] ?? '') }}" placeholder="https://domain.com/logo.svg" oninput="updateLogoPreview(this.value)" class="block w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400">
                        <div class="mt-2 p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-softcyan-400 to-softred-400 flex items-center justify-center text-slate-800 font-bold text-lg shadow-sm">
                                E
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Preview Brand</p>
                                <p class="text-[10px] text-slate-400">EnsiklopediaIT Brand Icon</p>
                            </div>
                        </div>
                    </div>

                    <!-- Favicon Setting -->
                    <div>
                        <label for="site_favicon" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Favicon URL</label>
                        <input type="url" name="site_favicon" id="site_favicon" value="{{ old('site_favicon', $settings['site_favicon'] ?? '') }}" placeholder="https://domain.com/favicon.ico" class="block w-full px-3 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-softcyan-400/50 focus:border-softcyan-400">
                    </div>
                </div>

                <!-- Google SEO Result Live Simulation -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
                    <h3 class="font-outfit font-bold text-xs uppercase tracking-wider text-slate-400">Simulasi Tampilan Google SERP</h3>
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 font-sans space-y-1">
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                            <span class="w-4 h-4 rounded-full bg-softcyan-400 text-[9px] text-slate-800 flex items-center justify-center font-bold">E</span>
                            <span class="truncate">https://ensiklopedia.it</span>
                        </div>
                        <h4 id="seo-title-preview" class="text-sm font-semibold text-softred-500 hover:underline cursor-pointer line-clamp-1">
                            {{ $settings['site_name'] ?? 'Ensiklopedia IT' }} - {{ $settings['site_tagline'] ?? 'Pusat Pengetahuan' }}
                        </h4>
                        <p id="seo-desc-preview" class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $settings['meta_description'] ?? 'Platform edukasi dan ensiklopedia teknologi terlengkap untuk engineer Indonesia.' }}
                        </p>
                    </div>
                </div>

                <!-- Save Action Card -->
                <div class="bg-softcyan-400/10 p-5 rounded-2xl border border-softcyan-400/20 space-y-3">
                    <p class="text-xs text-slate-700 font-medium">Pastikan semua data sudah sesuai sebelum menerapkan perubahan secara global ke seluruh website.</p>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-800 bg-softcyan-400 hover:bg-softcyan-500 shadow-md shadow-softcyan-400/20 transition-all hover:scale-[1.01]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Simpan Pengaturan Web</span>
                    </button>
                </div>

            </div>

        </div>
    </form>

    @push('scripts')
    <script>
        function updateSeoPreview() {
            const name = document.getElementById('site_name').value || 'Ensiklopedia IT';
            const tagline = document.getElementById('site_tagline').value || 'Pusat Pengetahuan IT';
            const desc = document.getElementById('meta_description').value || 'Deskripsi website di Google...';

            document.getElementById('seo-title-preview').innerText = `${name} - ${tagline}`;
            document.getElementById('seo-desc-preview').innerText = desc;
        }
    </script>
    @endpush
@endsection
