@extends('layouts.app')
@section('content')
<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100" x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center space-x-2">
                <div class="w-9 h-9 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                </div>
                <span class="text-lg font-bold text-gray-900">Undangan<span class="text-amber-500">Pro</span></span>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Fitur</a>
                <a href="#templates" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Template</a>
                <a href="#pricing" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Harga</a>
                <a href="#faq" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">FAQ</a>
            </div>
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl hover:from-amber-600 hover:to-amber-700 shadow-lg shadow-amber-500/25 transition-all">Daftar Gratis</a>
            </div>
            <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-transition class="md:hidden bg-white border-t border-gray-100 p-4 space-y-3">
        <a href="#features" class="block text-gray-600 py-2">Fitur</a>
        <a href="#pricing" class="block text-gray-600 py-2">Harga</a>
        <a href="{{ route('login') }}" class="block text-gray-600 py-2">Masuk</a>
        <a href="{{ route('register') }}" class="block w-full text-center py-2.5 bg-amber-500 text-white rounded-xl font-semibold">Daftar Gratis</a>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-white to-rose-50"></div>
    <div class="absolute top-20 right-10 w-72 h-72 bg-amber-200 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-20 left-10 w-96 h-96 bg-rose-200 rounded-full opacity-20 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center px-4 py-1.5 bg-amber-100 text-amber-700 rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Platform Undangan #1 di Indonesia
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                Undangan Digital<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-amber-700">Premium & Elegan</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Buat undangan pernikahan digital yang mewah dan modern. Ratusan template premium, RSVP otomatis, dan fitur lengkap untuk hari istimewa Anda.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-2xl shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 hover:from-amber-600 hover:to-amber-700 transition-all transform hover:scale-105 text-center">
                    Buat Undangan Gratis
                </a>
                <a href="#templates" class="w-full sm:w-auto px-8 py-4 bg-white text-gray-700 font-semibold rounded-2xl border-2 border-gray-200 hover:border-amber-300 hover:bg-amber-50 transition-all text-center">
                    Lihat Template
                </a>
            </div>
            <p class="mt-6 text-sm text-gray-500">Dipercaya oleh 10,000+ pasangan di Indonesia</p>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Fitur Premium untuk Momen Istimewa</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Semua yang Anda butuhkan untuk undangan pernikahan digital yang sempurna</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $features = [
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>', 'title' => 'Template Premium', 'desc' => 'Pilih dari koleksi template elegan yang dirancang profesional dengan berbagai tema.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>', 'title' => 'RSVP & Guest Management', 'desc' => 'Kelola daftar tamu, terima konfirmasi kehadiran, dan lacak statistik secara real-time.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>', 'title' => 'Galeri & Media', 'desc' => 'Upload foto unlimited dengan auto-compress, music player, dan slider yang cantik.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'title' => 'Countdown Timer', 'desc' => 'Tampilkan countdown yang elegan menuju hari bahagia dengan animasi yang smooth.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>', 'title' => 'Google Maps', 'desc' => 'Integrasi Google Maps untuk memudahkan tamu menemukan lokasi acara.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'title' => 'Amplop Digital', 'desc' => 'Terima hadiah digital via QRIS dan transfer bank secara aman dan praktis.'],
            ];
            @endphp

            @foreach($features as $feature)
            <div class="group p-8 rounded-3xl border border-gray-100 hover:border-amber-200 hover:shadow-xl hover:shadow-amber-500/5 transition-all duration-300">
                <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-amber-500 transition-colors duration-300">
                    <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $feature['icon'] !!}</svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="py-20 lg:py-32 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Pilih Paket yang Tepat</h2>
            <p class="text-lg text-gray-600">Harga transparan, tanpa biaya tersembunyi</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach($packages as $package)
            <div class="relative bg-white rounded-3xl border {{ $package->tier->value === 'premium' ? 'border-amber-300 shadow-xl shadow-amber-500/10 ring-2 ring-amber-400' : 'border-gray-200 shadow-lg' }} p-8 flex flex-col transition-all duration-300 hover:scale-105">
                @if($package->tier->value === 'premium')
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs font-bold rounded-full">POPULER</div>
                @endif

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900">{{ $package->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                </div>

                <div class="mb-6">
                    @if($package->discount_price)
                        <span class="text-sm text-gray-400 line-through">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    @endif
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($package->getEffectivePrice(), 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-500 ml-1">/tahun</span>
                    </div>
                </div>

                <ul class="space-y-3 mb-8 flex-1">
                    @foreach($package->features ?? [] as $feature)
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <span class="text-sm text-gray-600">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="block w-full text-center py-3 rounded-2xl font-semibold transition-all duration-200 {{ $package->tier->value === 'premium' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                    Pilih Paket
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Dipercaya Ribuan Pasangan</h2>
            <p class="text-lg text-gray-600">Apa kata mereka tentang platform kami</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $testimonials = [
                ['name' => 'Ariel & Rina', 'text' => 'Template undangannya sangat cantik dan elegan. Tamu-tamu kami semua terkesan dengan desainnya!', 'rating' => 5],
                ['name' => 'Ahmad & Siti', 'text' => 'Fitur RSVP sangat membantu kami mengelola tamu. Tidak perlu repot lagi menghitung konfirmasi satu per satu.', 'rating' => 5],
                ['name' => 'Budi & Diana', 'text' => 'Harganya sangat terjangkau dibanding cetak undangan fisik. Hasilnya pun sangat premium dan modern.', 'rating' => 5],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100">
                <div class="flex mb-4">
                    @for($i = 0; $i < $t['rating']; $i++)
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 mb-4 leading-relaxed">"{{ $t['text'] }}"</p>
                <p class="font-semibold text-gray-900">{{ $t['name'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-20 lg:py-32 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Pertanyaan Umum</h2>
        </div>
        <div class="space-y-4" x-data="{ open: null }">
            @php
            $faqs = [
                ['q' => 'Bagaimana cara membuat undangan?', 'a' => 'Cukup daftar akun gratis, pilih template, isi data pernikahan Anda, dan undangan siap dibagikan dalam hitungan menit.'],
                ['q' => 'Apakah undangan bisa diakses di semua device?', 'a' => 'Ya! Semua template kami sudah responsive dan tampil sempurna di smartphone, tablet, dan desktop.'],
                ['q' => 'Berapa lama undangan aktif?', 'a' => 'Undangan aktif selama 1 tahun sejak tanggal pembayaran. Anda bisa memperpanjang kapan saja.'],
                ['q' => 'Apakah bisa edit undangan setelah dipublish?', 'a' => 'Tentu! Anda bisa mengedit konten undangan kapan saja, bahkan setelah dipublish dan dibagikan.'],
                ['q' => 'Bagaimana sistem pembayarannya?', 'a' => 'Kami menggunakan Midtrans yang mendukung berbagai metode pembayaran: transfer bank, e-wallet, kartu kredit, dan QRIS.'],
            ];
            @endphp
            @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <button @click="open = open === {{ $index }} ? null : {{ $index }}" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-900">{{ $faq['q'] }}</span>
                    <svg :class="open === {{ $index }} ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open === {{ $index }}" x-collapse class="px-6 pb-6">
                    <p class="text-gray-600">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 lg:py-32 bg-gradient-to-br from-amber-500 via-amber-600 to-amber-700 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="cta-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1.5" fill="white"/></pattern></defs><rect width="400" height="400" fill="url(#cta-pattern)"/></svg>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-5xl font-bold text-white mb-6">Siap Membuat Undangan Impian Anda?</h2>
        <p class="text-lg text-white/80 mb-10">Bergabunglah dengan ribuan pasangan yang telah mempercayakan momen spesial mereka kepada kami.</p>
        <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-amber-600 font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
            Mulai Sekarang - Gratis!
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center space-x-2 mb-4 md:mb-0">
                <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                </div>
                <span class="text-white font-bold">UndanganPro</span>
            </div>
            <p class="text-sm">&copy; {{ date('Y') }} Undangan Digital Premium. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
