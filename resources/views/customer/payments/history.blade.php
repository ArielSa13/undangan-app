@extends('layouts.dashboard')
@section('page-title', 'Riwayat Pembayaran')
@section('sidebar') @include('customer._sidebar') @endsection

@section('dashboard-content')
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
    @if($payments->isEmpty())
        <div class="p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <p class="text-gray-500">Belum ada riwayat pembayaran.</p>
        </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 dark:border-gray-700">
                <th class="text-left p-4 font-medium text-gray-500">Order ID</th>
                <th class="text-left p-4 font-medium text-gray-500">Paket</th>
                <th class="text-left p-4 font-medium text-gray-500">Amount</th>
                <th class="text-left p-4 font-medium text-gray-500">Status</th>
                <th class="text-left p-4 font-medium text-gray-500">Tanggal</th>
            </tr></thead>
            <tbody>
                @foreach($payments as $payment)
                <tr class="border-b border-gray-50 dark:border-gray-700/50">
                    <td class="p-4 font-mono text-xs">{{ $payment->order_id }}</td>
                    <td class="p-4">{{ $payment->package->name ?? '-' }}</td>
                    <td class="p-4 font-medium">{{ $payment->getFormattedAmount() }}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded-lg text-xs font-medium
                        {{ $payment->status->value === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $payment->status->value === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $payment->status->value === 'failed' ? 'bg-red-100 text-red-700' : '' }}">{{ $payment->status->label() }}</span></td>
                    <td class="p-4 text-gray-500">{{ $payment->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
