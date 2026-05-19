@extends('layouts.dashboard')
@section('page-title', 'Edit Undangan')

@section('sidebar')
@include('customer._sidebar')
@endsection

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <div class="flex items-center space-x-2">
            @if($invitation->status->value === 'draft' || $invitation->status->value === 'paused')
                <form method="POST" action="{{ route('customer.invitations.publish', $invitation) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-xl hover:bg-green-600 transition-colors">Publish</button>
                </form>
            @elseif($invitation->status->value === 'published')
                <form method="POST" action="{{ route('customer.invitations.pause', $invitation) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-xl hover:bg-yellow-600 transition-colors">Pause</button>
                </form>
                <a href="{{ $invitation->getUrl() }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-xl hover:bg-blue-600 transition-colors">Lihat</a>
            @endif
            <form method="POST" action="{{ route('customer.invitations.duplicate', $invitation) }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-300 transition-colors">Duplikasi</button>
            </form>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('customer.guests.index', $invitation) }}" class="px-4 py-2 bg-white border border-gray-200 text-sm rounded-xl hover:bg-gray-50 transition-colors">
            Kelola Tamu ({{ $invitation->guests_count ?? $invitation->guests()->count() }})
        </a>
        <a href="{{ route('customer.gallery.index', $invitation) }}" class="px-4 py-2 bg-white border border-gray-200 text-sm rounded-xl hover:bg-gray-50 transition-colors">
            Galeri Foto ({{ $invitation->galleries()->count() }})
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-700">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('customer.invitations.update', $invitation) }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- URL/Slug -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">URL Undangan</h3>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">{{ url('/') }}/</span>
                <input type="text" name="slug" value="{{ old('slug', $invitation->slug) }}" class="flex-1 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
            </div>
        </div>

        <!-- Template -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Template</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                @foreach($templates as $template)
                <label class="cursor-pointer">
                    <input type="radio" name="template_id" value="{{ $template->id }}" class="peer hidden" {{ $invitation->template_id == $template->id ? 'checked' : '' }}>
                    <div class="p-2 rounded-xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 transition-all text-center">
                        <p class="text-xs font-medium text-gray-900 dark:text-white truncate">{{ $template->name }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Couple Data -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Mempelai</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="text-sm font-medium text-amber-600 uppercase tracking-wide">Mempelai Pria</h4>
                    <input type="text" name="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="text" name="groom_father" value="{{ old('groom_father', $invitation->groom_father) }}" placeholder="Nama Ayah" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="text" name="groom_mother" value="{{ old('groom_mother', $invitation->groom_mother) }}" placeholder="Nama Ibu" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="text" name="groom_instagram" value="{{ old('groom_instagram', $invitation->groom_instagram) }}" placeholder="Instagram" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="file" name="groom_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700">
                </div>
                <div class="space-y-4">
                    <h4 class="text-sm font-medium text-rose-600 uppercase tracking-wide">Mempelai Wanita</h4>
                    <input type="text" name="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="text" name="bride_father" value="{{ old('bride_father', $invitation->bride_father) }}" placeholder="Nama Ayah" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="text" name="bride_mother" value="{{ old('bride_mother', $invitation->bride_mother) }}" placeholder="Nama Ibu" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="text" name="bride_instagram" value="{{ old('bride_instagram', $invitation->bride_instagram) }}" placeholder="Instagram" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    <input type="file" name="bride_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-rose-50 file:text-rose-700">
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Acara</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="date" name="event_date" value="{{ old('event_date', $invitation->event_date?->format('Y-m-d')) }}" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                <input type="time" name="event_time_start" value="{{ old('event_time_start', $invitation->event_time_start) }}" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                <input type="text" name="event_venue" value="{{ old('event_venue', $invitation->event_venue) }}" placeholder="Venue" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                <input type="url" name="event_maps_url" value="{{ old('event_maps_url', $invitation->event_maps_url) }}" placeholder="Google Maps URL" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
                <textarea name="event_address" rows="2" placeholder="Alamat lengkap" class="md:col-span-2 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none resize-none">{{ old('event_address', $invitation->event_address) }}</textarea>
            </div>
        </div>

        <!-- Content & Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Konten & Pengaturan</h3>
            <div class="space-y-4">
                <textarea name="opening_text" rows="3" placeholder="Kata pembuka" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none resize-none">{{ old('opening_text', $invitation->opening_text) }}</textarea>
                <textarea name="closing_text" rows="3" placeholder="Kata penutup" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none resize-none">{{ old('closing_text', $invitation->closing_text) }}</textarea>
                <input type="text" name="dress_code" value="{{ old('dress_code', $invitation->dress_code) }}" placeholder="Dress code (opsional)" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none">
            </div>

            <!-- Feature Toggles -->
            <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                @php $toggles = ['is_rsvp_enabled' => 'RSVP', 'is_guestbook_enabled' => 'Buku Tamu', 'is_gallery_enabled' => 'Galeri', 'is_countdown_enabled' => 'Countdown', 'is_music_enabled' => 'Music', 'is_maps_enabled' => 'Maps', 'is_love_story_enabled' => 'Love Story', 'is_gift_enabled' => 'Amplop Digital']; @endphp
                @foreach($toggles as $field => $label)
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="hidden" name="{{ $field }}" value="0">
                    <input type="checkbox" name="{{ $field }}" value="1" {{ old($field, $invitation->$field) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between">
            <form method="POST" action="{{ route('customer.invitations.destroy', $invitation) }}" onsubmit="return confirm('Yakin ingin menghapus undangan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-3 text-red-600 bg-red-50 rounded-xl hover:bg-red-100 font-medium transition-colors">Hapus Undangan</button>
            </form>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-amber-700 shadow-lg shadow-amber-500/25 transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
