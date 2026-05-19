@extends('layouts.dashboard')
@section('page-title', 'Galeri Foto')
@section('sidebar') @include('customer._sidebar') @endsection

@section('dashboard-content')
<div class="mb-6">
    <a href="{{ route('customer.invitations.edit', $invitation) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
    </a>
</div>

<!-- Upload -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Upload Foto</h3>
    <form method="POST" action="{{ route('customer.gallery.store', $invitation) }}" enctype="multipart/form-data" class="flex items-end space-x-4">
        @csrf
        <div class="flex-1">
            <input type="file" name="images[]" multiple accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
            <p class="text-xs text-gray-500 mt-1">Bisa upload banyak foto sekaligus. Maks 5MB/foto.</p>
        </div>
        <button type="submit" class="px-6 py-2 bg-amber-500 text-white rounded-xl text-sm font-medium hover:bg-amber-600 transition-colors">Upload</button>
    </form>
</div>

<!-- Gallery Grid -->
@if($galleries->count())
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($galleries as $gallery)
    <div class="relative group rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
        <img src="{{ Storage::url($gallery->image_path) }}" class="w-full aspect-square object-cover" alt="">
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
            <form method="POST" action="{{ route('customer.gallery.destroy', [$invitation, $gallery]) }}">
                @csrf @method('DELETE')
                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-xs rounded-lg hover:bg-red-600">Hapus</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-12 text-center">
    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    <p class="text-gray-500">Belum ada foto. Upload foto pertama Anda!</p>
</div>
@endif
@endsection
