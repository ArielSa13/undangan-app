@extends('layouts.dashboard')
@section('page-title', 'Kelola Tamu')
@section('sidebar') @include('customer._sidebar') @endsection

@section('dashboard-content')
<div class="mb-6">
    <a href="{{ route('customer.invitations.edit', $invitation) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
    </a>
</div>

<!-- RSVP Stats -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 text-center">
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
        <p class="text-xs text-gray-500">Total</p>
    </div>
    <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-100 text-center">
        <p class="text-2xl font-bold text-green-600">{{ $stats['attending'] }}</p>
        <p class="text-xs text-green-600">Hadir</p>
    </div>
    <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-100 text-center">
        <p class="text-2xl font-bold text-red-600">{{ $stats['not_attending'] }}</p>
        <p class="text-xs text-red-600">Tidak Hadir</p>
    </div>
    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 border border-yellow-100 text-center">
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        <p class="text-xs text-yellow-600">Pending</p>
    </div>
</div>

<!-- Add Guest -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tambah Tamu</h3>
    <form method="POST" action="{{ route('customer.guests.store', $invitation) }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
        @csrf
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Nama *</label>
            <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 outline-none text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Phone</label>
            <input type="text" name="phone" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 outline-none text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Group</label>
            <input type="text" name="group" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 outline-none text-sm" placeholder="Keluarga/Teman">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Max Pax</label>
            <input type="number" name="max_pax" value="2" min="1" max="10" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 outline-none text-sm">
        </div>
        <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded-xl text-sm font-medium hover:bg-amber-600 transition-colors">Tambah</button>
    </form>
</div>

<!-- Guest List -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 dark:border-gray-700">
                <th class="text-left p-4 font-medium text-gray-500">Nama</th>
                <th class="text-left p-4 font-medium text-gray-500">Phone</th>
                <th class="text-left p-4 font-medium text-gray-500">Group</th>
                <th class="text-left p-4 font-medium text-gray-500">RSVP</th>
                <th class="text-left p-4 font-medium text-gray-500">Link</th>
                <th class="p-4"></th>
            </tr></thead>
            <tbody>
                @forelse($guests as $guest)
                <tr class="border-b border-gray-50 dark:border-gray-700/50">
                    <td class="p-4 font-medium text-gray-900 dark:text-white">{{ $guest->name }}</td>
                    <td class="p-4 text-gray-600">{{ $guest->phone ?? '-' }}</td>
                    <td class="p-4 text-gray-600">{{ $guest->group ?? '-' }}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded-lg text-xs font-medium
                        {{ $guest->rsvp_status->value === 'attending' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $guest->rsvp_status->value === 'not_attending' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $guest->rsvp_status->value === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
                        {{ $guest->rsvp_status->value === 'maybe' ? 'bg-yellow-100 text-yellow-700' : '' }}">{{ $guest->rsvp_status->label() }}</span></td>
                    <td class="p-4">
                        <button onclick="navigator.clipboard.writeText('{{ $invitation->getPersonalUrl($guest->name) }}')" class="text-xs text-amber-600 hover:underline">Copy Link</button>
                    </td>
                    <td class="p-4">
                        <form method="POST" action="{{ route('customer.guests.destroy', [$invitation, $guest]) }}" onsubmit="return confirm('Hapus tamu ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-500">Belum ada tamu. Tambahkan tamu pertama di atas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $guests->links() }}</div>
</div>
@endsection
