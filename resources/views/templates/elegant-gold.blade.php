<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $invitation->groom_name }} & {{ $invitation->bride_name }} - Undangan Pernikahan</title>
    <meta name="description" content="Undangan Pernikahan {{ $invitation->groom_name }} & {{ $invitation->bride_name }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --color-primary: {{ $invitation->primary_color ?? '#D4AF37' }}; --color-secondary: {{ $invitation->secondary_color ?? '#1a1a2e' }}; }
        body { font-family: 'Lato', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .text-gold { color: var(--color-primary); }
        .bg-gold { background-color: var(--color-primary); }
        .border-gold { border-color: var(--color-primary); }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
    </style>
</head>
<body class="bg-white text-gray-800" x-data="{ opened: false, musicPlaying: false }">

<!-- Opening Cover -->
<section x-show="!opened" class="fixed inset-0 z-50 flex items-center justify-center bg-gradient-to-b from-amber-50 to-white" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="text-center px-6 animate-fade-in-up">
        <p class="text-sm tracking-[0.3em] uppercase text-gray-500 mb-4">The Wedding of</p>
        <h1 class="text-4xl sm:text-5xl font-serif text-gold mb-2">{{ $invitation->groom_name }}</h1>
        <p class="text-2xl font-serif text-gold mb-1">&</p>
        <h1 class="text-4xl sm:text-5xl font-serif text-gold mb-6">{{ $invitation->bride_name }}</h1>
        @if($guestName)
            <p class="text-gray-600 mb-2">Kepada Yth.</p>
            <p class="text-lg font-semibold text-gray-800 mb-6">{{ $guestName }}</p>
        @endif
        <button @click="opened = true; if({{ $invitation->music_autoplay ? 'true' : 'false' }}) { $refs.audio?.play(); musicPlaying = true; }" class="px-8 py-3 bg-gold text-white font-medium rounded-full hover:opacity-90 transition-opacity shadow-lg">
            Buka Undangan
        </button>
    </div>
</section>

<!-- Main Content -->
<main x-show="opened" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center text-center px-6 py-20 bg-gradient-to-b from-amber-50 to-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-32 h-32 border-l-2 border-t-2 border-gold opacity-30 m-8"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 border-r-2 border-b-2 border-gold opacity-30 m-8"></div>
        <div class="relative z-10">
            <p class="text-sm tracking-[0.3em] uppercase text-gray-500 mb-6">The Wedding of</p>
            <h1 class="text-5xl sm:text-7xl font-serif text-gold mb-4">{{ $invitation->groom_name }}</h1>
            <p class="text-3xl font-serif text-gold my-3">&</p>
            <h1 class="text-5xl sm:text-7xl font-serif text-gold mb-8">{{ $invitation->bride_name }}</h1>
            <p class="text-lg text-gray-600">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
        </div>
    </section>

    <!-- Opening Text -->
    @if($invitation->opening_text)
    <section class="py-20 px-6 text-center max-w-2xl mx-auto">
        <div class="w-16 h-px bg-gold mx-auto mb-8"></div>
        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $invitation->opening_text }}</p>
        <div class="w-16 h-px bg-gold mx-auto mt-8"></div>
    </section>
    @endif

    <!-- Couple Profile -->
    <section class="py-20 px-6 bg-amber-50/50">
        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 text-center">
            <div>
                @if($invitation->groom_photo)
                <img src="{{ Storage::url($invitation->groom_photo) }}" class="w-48 h-48 rounded-full mx-auto mb-6 object-cover border-4 border-gold/30" alt="{{ $invitation->groom_name }}">
                @else
                <div class="w-48 h-48 rounded-full mx-auto mb-6 bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center border-4 border-gold/30">
                    <span class="text-4xl font-serif text-gold">{{ substr($invitation->groom_name, 0, 1) }}</span>
                </div>
                @endif
                <h3 class="text-2xl font-serif text-gold mb-2">{{ $invitation->groom_name }}</h3>
                @if($invitation->groom_father || $invitation->groom_mother)
                <p class="text-gray-600 text-sm">Putra dari Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}</p>
                @endif
            </div>
            <div>
                @if($invitation->bride_photo)
                <img src="{{ Storage::url($invitation->bride_photo) }}" class="w-48 h-48 rounded-full mx-auto mb-6 object-cover border-4 border-gold/30" alt="{{ $invitation->bride_name }}">
                @else
                <div class="w-48 h-48 rounded-full mx-auto mb-6 bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center border-4 border-gold/30">
                    <span class="text-4xl font-serif text-gold">{{ substr($invitation->bride_name, 0, 1) }}</span>
                </div>
                @endif
                <h3 class="text-2xl font-serif text-gold mb-2">{{ $invitation->bride_name }}</h3>
                @if($invitation->bride_father || $invitation->bride_mother)
                <p class="text-gray-600 text-sm">Putri dari Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Countdown -->
    @if($invitation->is_countdown_enabled)
    <section class="py-20 px-6 text-center" x-data="countdown('{{ $invitation->event_date->format('Y-m-d') }}T{{ $invitation->event_time_start }}')">
        <h2 class="text-3xl font-serif text-gold mb-10">Menghitung Hari</h2>
        <div class="flex justify-center space-x-4 sm:space-x-8">
            <div class="text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gold/10 rounded-2xl flex items-center justify-center mb-2"><span class="text-2xl sm:text-3xl font-bold text-gold" x-text="days">0</span></div>
                <span class="text-xs text-gray-500">Hari</span>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gold/10 rounded-2xl flex items-center justify-center mb-2"><span class="text-2xl sm:text-3xl font-bold text-gold" x-text="hours">0</span></div>
                <span class="text-xs text-gray-500">Jam</span>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gold/10 rounded-2xl flex items-center justify-center mb-2"><span class="text-2xl sm:text-3xl font-bold text-gold" x-text="minutes">0</span></div>
                <span class="text-xs text-gray-500">Menit</span>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gold/10 rounded-2xl flex items-center justify-center mb-2"><span class="text-2xl sm:text-3xl font-bold text-gold" x-text="seconds">0</span></div>
                <span class="text-xs text-gray-500">Detik</span>
            </div>
        </div>
    </section>
    @endif

    <!-- Event Details -->
    <section class="py-20 px-6 bg-amber-50/50">
        <h2 class="text-3xl font-serif text-gold text-center mb-12">Detail Acara</h2>
        <div class="max-w-2xl mx-auto text-center space-y-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gold/10">
                <h3 class="text-xl font-serif text-gold mb-2">Akad Nikah</h3>
                <p class="text-gray-700 font-medium">{{ $invitation->event_date->translatedFormat('l, d F Y') }}</p>
                <p class="text-gray-600">Pukul {{ \Carbon\Carbon::parse($invitation->event_time_start)->format('H:i') }} {{ $invitation->event_time_end ? '- ' . \Carbon\Carbon::parse($invitation->event_time_end)->format('H:i') : '' }} WIB</p>
                <p class="text-gray-600 mt-2">{{ $invitation->event_venue }}</p>
                @if($invitation->event_address)<p class="text-gray-500 text-sm mt-1">{{ $invitation->event_address }}</p>@endif
            </div>

            @if($invitation->reception_venue)
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gold/10">
                <h3 class="text-xl font-serif text-gold mb-2">Resepsi</h3>
                <p class="text-gray-700 font-medium">{{ ($invitation->reception_date ?? $invitation->event_date)->translatedFormat('l, d F Y') }}</p>
                @if($invitation->reception_time_start)<p class="text-gray-600">Pukul {{ \Carbon\Carbon::parse($invitation->reception_time_start)->format('H:i') }} {{ $invitation->reception_time_end ? '- ' . \Carbon\Carbon::parse($invitation->reception_time_end)->format('H:i') : '' }} WIB</p>@endif
                <p class="text-gray-600 mt-2">{{ $invitation->reception_venue }}</p>
                @if($invitation->reception_address)<p class="text-gray-500 text-sm mt-1">{{ $invitation->reception_address }}</p>@endif
            </div>
            @endif
        </div>
    </section>

    <!-- Google Maps -->
    @if($invitation->is_maps_enabled && $invitation->event_maps_url)
    <section class="py-20 px-6">
        <h2 class="text-3xl font-serif text-gold text-center mb-8">Lokasi</h2>
        <div class="max-w-3xl mx-auto rounded-2xl overflow-hidden shadow-lg">
            <iframe src="{{ str_replace('/maps/', '/maps/embed/', $invitation->event_maps_url) }}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" class="w-full"></iframe>
        </div>
        <div class="text-center mt-4">
            <a href="{{ $invitation->event_maps_url }}" target="_blank" class="inline-flex items-center px-6 py-2 bg-gold text-white rounded-full text-sm hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                Buka di Google Maps
            </a>
        </div>
    </section>
    @endif

    <!-- Gallery -->
    @if($invitation->is_gallery_enabled && $invitation->galleries->count())
    <section class="py-20 px-6 bg-amber-50/50">
        <h2 class="text-3xl font-serif text-gold text-center mb-10">Galeri</h2>
        <div class="max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($invitation->galleries as $gallery)
            <div class="aspect-square rounded-2xl overflow-hidden">
                <img src="{{ Storage::url($gallery->image_path) }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" alt="{{ $gallery->caption }}">
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- RSVP -->
    @if($invitation->is_rsvp_enabled)
    <section class="py-20 px-6">
        <h2 class="text-3xl font-serif text-gold text-center mb-10">Konfirmasi Kehadiran</h2>
        <div class="max-w-md mx-auto">
            @if(session('rsvp_success'))
                <div class="p-6 bg-green-50 border border-green-200 rounded-2xl text-center">
                    <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-green-700 font-medium">{{ session('rsvp_success') }}</p>
                </div>
            @else
            <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" class="space-y-4">
                @csrf
                <input type="text" name="name" value="{{ $guestName ?? '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none">
                <select name="rsvp_status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none">
                    <option value="">Konfirmasi Kehadiran</option>
                    <option value="attending">Hadir</option>
                    <option value="not_attending">Tidak Hadir</option>
                    <option value="maybe">Mungkin Hadir</option>
                </select>
                <input type="number" name="attending_count" min="1" max="10" value="1" placeholder="Jumlah yang hadir" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none">
                <textarea name="rsvp_note" rows="2" placeholder="Catatan (opsional)" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none resize-none"></textarea>
                <button type="submit" class="w-full py-3 bg-gold text-white font-medium rounded-xl hover:opacity-90 transition-opacity">Kirim Konfirmasi</button>
            </form>
            @endif
        </div>
    </section>
    @endif

    <!-- Guestbook -->
    @if($invitation->is_guestbook_enabled)
    <section class="py-20 px-6 bg-amber-50/50">
        <h2 class="text-3xl font-serif text-gold text-center mb-10">Ucapan & Doa</h2>
        <div class="max-w-2xl mx-auto">
            @if(session('guestbook_success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-center text-green-700 text-sm">{{ session('guestbook_success') }}</div>
            @endif
            <form method="POST" action="{{ route('invitation.guestbook', $invitation->slug) }}" class="mb-8 space-y-4">
                @csrf
                <input type="text" name="name" value="{{ $guestName ?? '' }}" placeholder="Nama Anda" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none">
                <textarea name="message" rows="3" placeholder="Tulis ucapan & doa..." required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-gold focus:ring-2 focus:ring-gold/20 outline-none resize-none"></textarea>
                <button type="submit" class="w-full py-3 bg-gold text-white font-medium rounded-xl hover:opacity-90 transition-opacity">Kirim Ucapan</button>
            </form>

            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($invitation->guestbooks as $msg)
                <div class="p-4 bg-white rounded-xl border border-gold/10">
                    <p class="font-medium text-gray-900 text-sm">{{ $msg->name }}</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $msg->message }}</p>
                    <p class="text-xs text-gray-400 mt-2">{{ $msg->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Digital Envelope -->
    @if($invitation->is_gift_enabled && ($invitation->bank_name || $invitation->qris_image))
    <section class="py-20 px-6">
        <h2 class="text-3xl font-serif text-gold text-center mb-4">Amplop Digital</h2>
        <p class="text-center text-gray-600 mb-10 max-w-md mx-auto">Doa restu Anda sudah cukup bagi kami. Namun jika berkenan, Anda bisa memberikan hadiah melalui:</p>
        <div class="max-w-md mx-auto space-y-4">
            @if($invitation->bank_name)
            <div class="p-6 bg-amber-50 rounded-2xl border border-gold/20 text-center">
                <p class="text-sm text-gray-500 mb-1">{{ $invitation->bank_name }}</p>
                <p class="text-xl font-bold text-gray-900 mb-1">{{ $invitation->bank_account }}</p>
                <p class="text-sm text-gray-600">a.n. {{ $invitation->bank_holder }}</p>
            </div>
            @endif
            @if($invitation->qris_image)
            <div class="p-6 bg-amber-50 rounded-2xl border border-gold/20 text-center">
                <p class="text-sm text-gray-500 mb-3">QRIS</p>
                <img src="{{ Storage::url($invitation->qris_image) }}" class="w-48 mx-auto rounded-xl" alt="QRIS">
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Closing -->
    @if($invitation->closing_text)
    <section class="py-20 px-6 text-center bg-amber-50/50">
        <div class="max-w-2xl mx-auto">
            <div class="w-16 h-px bg-gold mx-auto mb-8"></div>
            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $invitation->closing_text }}</p>
            <div class="mt-8">
                <p class="text-2xl font-serif text-gold">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</p>
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="py-8 text-center text-sm text-gray-400 border-t">
        <p>Created with &hearts; by <a href="{{ url('/') }}" class="text-gold hover:underline">UndanganPro</a></p>
    </footer>
</main>

<!-- Music Player -->
@if($invitation->is_music_enabled && $invitation->music_url)
<div x-show="opened" class="fixed bottom-6 right-6 z-40">
    <button @click="musicPlaying ? $refs.audio.pause() : $refs.audio.play(); musicPlaying = !musicPlaying"
            class="w-12 h-12 bg-gold text-white rounded-full shadow-lg flex items-center justify-center hover:opacity-90 transition-opacity"
            :class="musicPlaying ? 'animate-pulse' : ''">
        <svg x-show="!musicPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
        <svg x-show="musicPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
    </button>
    <audio x-ref="audio" loop>
        <source src="{{ Storage::url($invitation->music_url) }}" type="audio/mpeg">
    </audio>
</div>
@endif

<script>
function countdown(targetDate) {
    return {
        days: 0, hours: 0, minutes: 0, seconds: 0,
        init() {
            this.update();
            setInterval(() => this.update(), 1000);
        },
        update() {
            const now = new Date().getTime();
            const target = new Date(targetDate).getTime();
            const diff = Math.max(0, target - now);
            this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
        }
    };
}
</script>
</body>
</html>
