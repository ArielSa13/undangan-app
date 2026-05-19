@extends('layouts.dashboard')
@section('page-title', $invitation->groom_name . ' & ' . $invitation->bride_name)
@section('sidebar') @include('customer._sidebar') @endsection

@section('dashboard-content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <div class="flex items-center space-x-2">
            <a href="{{ route('customer.invitations.edit', $invitation) }}" class="px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-xl hover:bg-amber-600">Edit</a>
            @if($invitation->isPublished())
            <a href="{{ $invitation->getUrl() }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-xl hover:bg-blue-600">Lihat Undangan</a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Detail Undangan</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $invitation->status->label() }}</dd></div>
                    <div><dt class="text-gray-500">Template</dt><dd class="font-medium">{{ $invitation->template->name }}</dd></div>
                    <div><dt class="text-gray-500">Tanggal</dt><dd class="font-medium">{{ $invitation->event_date->format('d M Y') }}</dd></div>
                    <div><dt class="text-gray-500">Venue</dt><dd class="font-medium">{{ $invitation->event_venue }}</dd></div>
                    <div><dt class="text-gray-500">URL</dt><dd class="font-medium text-amber-600">{{ $invitation->getUrl() }}</dd></div>
                    <div><dt class="text-gray-500">Views</dt><dd class="font-medium">{{ number_format($invitation->view_count) }}</dd></div>
                </dl>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">RSVP</h3>
                @php $stats = $invitation->getRsvpStats(); @endphp
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Total Tamu</span><span class="font-medium">{{ $stats['total'] }}</span></div>
                    <div class="flex justify-between"><span class="text-green-600">Hadir</span><span class="font-medium">{{ $stats['attending'] }}</span></div>
                    <div class="flex justify-between"><span class="text-red-600">Tidak Hadir</span><span class="font-medium">{{ $stats['not_attending'] }}</span></div>
                    <div class="flex justify-between"><span class="text-yellow-600">Pending</span><span class="font-medium">{{ $stats['pending'] }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
