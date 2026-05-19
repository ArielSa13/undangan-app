@extends('layouts.dashboard')
@section('page-title', 'Kelola Pembayaran')
@section('sidebar') @include('admin._sidebar') @endsection

@section('dashboard-content')
<!-- Revenue Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <p class="text-sm text-gray-500">Total Revenue</p>
        <p class="text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <p class="text-sm text-gray-500">Bulan Ini</p>
        <p class="text-xl font-bold text-green-600">Rp {{ number_format($stats['this_month'], 0, ',', '.') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-xl font-bold text-yellow-600">{{ $stats['pending_count'] }}</p>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 dark:border-gray-700">
                <th class="text-left p-4 font-medium text-gray-500">Order ID</th>
                <th class="text-left p-4 font-medium text-gray-500">User</th>
                <th class="text-left p-4 font-medium text-gray-500">Paket</th>
                <th class="text-left p-4 font-medium text-gray-500">Amount</th>
                <th class="text-left p-4 font-medium text-gray-500">Status</th>
                <th class="text-left p-4 font-medium text-gray-500">Date</th>
            </tr></thead>
            <tbody>
                @foreach($payments as $payment)
                <tr class="border-b border-gray-50 dark:border-gray-700/50">
                    <td class="p-4 font-mono text-xs">{{ $payment->order_id }}</td>
                    <td class="p-4">{{ $payment->user->name ?? '-' }}</td>
                    <td class="p-4">{{ $payment->package->name ?? '-' }}</td>
                    <td class="p-4 font-medium">{{ $payment->getFormattedAmount() }}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded-lg text-xs font-medium
                        {{ $payment->status->value === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $payment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $payment->status->value === 'failed' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $payment->status->value === 'expired' ? 'bg-gray-100 text-gray-700' : '' }}">{{ $payment->status->label() }}</span></td>
                    <td class="p-4 text-gray-500">{{ $payment->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $payments->withQueryString()->links() }}</div>
</div>
@endsection
