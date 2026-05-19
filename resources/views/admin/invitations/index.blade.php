@extends('layouts.dashboard')
@section('page-title', 'Kelola Undangan')
@section('sidebar') @include('admin._sidebar') @endsection

@section('dashboard-content')
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
        <form method="GET" class="flex items-center space-x-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari undangan..." class="flex-1 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 outline-none text-sm">
            <select name="status" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 text-sm" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="paused" {{ request('status') === 'paused' ? 'selected' : '' }}>Paused</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded-xl text-sm font-medium">Cari</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 dark:border-gray-700">
                <th class="text-left p-4 font-medium text-gray-500">Undangan</th>
                <th class="text-left p-4 font-medium text-gray-500">User</th>
                <th class="text-left p-4 font-medium text-gray-500">Template</th>
                <th class="text-left p-4 font-medium text-gray-500">Status</th>
                <th class="text-left p-4 font-medium text-gray-500">Views</th>
                <th class="text-left p-4 font-medium text-gray-500">Tanggal</th>
            </tr></thead>
            <tbody>
                @foreach($invitations as $inv)
                <tr class="border-b border-gray-50 dark:border-gray-700/50">
                    <td class="p-4">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $inv->groom_name }} & {{ $inv->bride_name }}</p>
                        <p class="text-xs text-gray-500">{{ $inv->slug }}</p>
                    </td>
                    <td class="p-4 text-gray-600">{{ $inv->user->name ?? '-' }}</td>
                    <td class="p-4 text-gray-600">{{ $inv->template->name ?? '-' }}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded-lg text-xs font-medium
                        {{ $inv->status->value === 'published' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $inv->status->value === 'draft' ? 'bg-gray-100 text-gray-700' : '' }}
                        {{ $inv->status->value === 'paused' ? 'bg-yellow-100 text-yellow-700' : '' }}">{{ $inv->status->label() }}</span></td>
                    <td class="p-4 text-gray-600">{{ number_format($inv->view_count) }}</td>
                    <td class="p-4 text-gray-500">{{ $inv->event_date->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $invitations->withQueryString()->links() }}</div>
</div>
@endsection
