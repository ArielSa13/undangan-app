@extends('layouts.dashboard')
@section('page-title', 'Undangan Saya')

@section('sidebar')
@include('customer._sidebar')
@endsection

@section('dashboard-content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-600 dark:text-gray-400">Kelola semua undangan digital Anda</p>
    <a href="{{ route('customer.invitations.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-sm font-semibold rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all shadow-lg shadow-amber-500/25">
        + Buat Undangan
    </a>
</div>

@if($invitations->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-12 text-center">
        <div class="w-20 h-20 mx-auto bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Undangan</h3>
        <p class="text-gray-500 mb-6">Mulai buat undangan digital pertama Anda!</p>
        <a href="{{ route('customer.invitations.create') }}" class="inline-flex items-center px-6 py-3 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 transition-colors">
            Buat Undangan Pertama
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($invitations as $invitation)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="h-32 bg-gradient-to-br from-amber-100 to-rose-100 dark:from-amber-900/30 dark:to-rose-900/30 flex items-center justify-center relative">
                @if($invitation->cover_image)
                    <img src="{{ Storage::url($invitation->cover_image) }}" class="w-full h-full object-cover" alt="">
                @else
                    <svg class="w-12 h-12 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                @endif
                <span class="absolute top-3 right-3 px-2.5 py-1 text-xs font-medium rounded-full
                    {{ $invitation->status->value === 'published' ? 'bg-green-500 text-white' : '' }}
                    {{ $invitation->status->value === 'draft' ? 'bg-gray-500 text-white' : '' }}
                    {{ $invitation->status->value === 'paused' ? 'bg-yellow-500 text-white' : '' }}">
                    {{ $invitation->status->label() }}
                </span>
            </div>
            <div class="p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h3>
                <p class="text-sm text-gray-500 mb-3">{{ $invitation->event_date->format('d M Y') }}</p>
                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                    <span>{{ $invitation->view_count }} views</span>
                    <span>{{ $invitation->template->name ?? '-' }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('customer.invitations.edit', $invitation) }}" class="flex-1 text-center py-2 text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Edit</a>
                    @if($invitation->status->value === 'published')
                        <a href="{{ $invitation->getUrl() }}" target="_blank" class="flex-1 text-center py-2 text-sm font-medium bg-amber-100 text-amber-700 rounded-xl hover:bg-amber-200 transition-colors">Lihat</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-8">{{ $invitations->links() }}</div>
@endif
@endsection
