@extends('layouts.dashboard')
@section('page-title', 'Buat Undangan Baru')

@section('sidebar')
@include('customer._sidebar')
@endsection

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('customer.invitations.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-700">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('customer.invitations.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Template Selection -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih Template</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($templates as $template)
                <label class="cursor-pointer">
                    <input type="radio" name="template_id" value="{{ $template->id }}" class="peer hidden" {{ old('template_id') == $template->id ? 'checked' : '' }} {{ $loop->first && !old('template_id') ? 'checked' : '' }}>
                    <div class="p-3 rounded-xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20 transition-all hover:border-amber-300">
                        <div class="h-20 bg-gradient-to-br from-amber-100 to-rose-100 rounded-lg mb-2 flex items-center justify-center">
                            <svg class="w-8 h-8 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                        </div>
                        <p class="text-xs font-medium text-gray-900 dark:text-white text-center truncate">{{ $template->name }}</p>
                        @if($template->is_premium)
                            <p class="text-xs text-amber-600 text-center">Premium</p>
                        @endif
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Couple Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Mempelai</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-amber-600 mb-3 uppercase tracking-wide">Mempelai Pria</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap *</label>
                            <input type="text" name="groom_name" value="{{ old('groom_name') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ayah</label>
                            <input type="text" name="groom_father" value="{{ old('groom_father') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ibu</label>
                            <input type="text" name="groom_mother" value="{{ old('groom_mother') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-rose-600 mb-3 uppercase tracking-wide">Mempelai Wanita</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap *</label>
                            <input type="text" name="bride_name" value="{{ old('bride_name') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ayah</label>
                            <input type="text" name="bride_father" value="{{ old('bride_father') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Ibu</label>
                            <input type="text" name="bride_mother" value="{{ old('bride_mother') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Acara</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Acara *</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Mulai *</label>
                    <input type="time" name="event_time_start" value="{{ old('event_time_start') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Venue/Tempat *</label>
                    <input type="text" name="event_venue" value="{{ old('event_venue') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Google Maps URL</label>
                    <input type="url" name="event_maps_url" value="{{ old('event_maps_url') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all" placeholder="https://maps.google.com/...">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                    <textarea name="event_address" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all resize-none">{{ old('event_address') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Konten Undangan</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Pembuka</label>
                    <textarea name="opening_text" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all resize-none" placeholder="Assalamualaikum Warahmatullahi Wabarakatuh...">{{ old('opening_text') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Penutup</label>
                    <textarea name="closing_text" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all resize-none" placeholder="Merupakan suatu kehormatan bagi kami...">{{ old('closing_text') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Media</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Background Music (MP3)</label>
                    <input type="file" name="music_url" accept=".mp3,.wav" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('customer.invitations.index') }}" class="px-6 py-3 text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 font-medium transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-amber-700 shadow-lg shadow-amber-500/25 transition-all">
                Buat Undangan
            </button>
        </div>
    </form>
</div>
@endsection
