@extends('layouts.dashboard')
@section('page-title', 'Pembayaran')
@section('sidebar') @include('customer._sidebar') @endsection

@section('dashboard-content')
<div class="max-w-lg mx-auto text-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-8">
        <div class="w-16 h-16 mx-auto bg-amber-100 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Lakukan Pembayaran</h3>
        <p class="text-gray-600 mb-2">Order ID: <span class="font-mono text-sm">{{ $payment->order_id }}</span></p>
        <p class="text-2xl font-bold text-amber-600 mb-6">{{ $payment->getFormattedAmount() }}</p>

        @if($payment->snap_token)
        <button id="pay-button" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 hover:from-amber-600 hover:to-amber-700 transition-all">
            Bayar dengan Midtrans
        </button>
        @else
        <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
            <p class="text-sm text-red-700">Gagal membuat pembayaran. Silakan coba lagi.</p>
        </div>
        @endif

        <a href="{{ route('customer.dashboard') }}" class="inline-block mt-4 text-sm text-gray-500 hover:text-gray-700">Kembali ke Dashboard</a>
    </div>
</div>

@if($payment->snap_token)
@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function() {
    snap.pay('{{ $payment->snap_token }}', {
        onSuccess: function(result) { window.location.href = '{{ route("customer.dashboard") }}?payment=success'; },
        onPending: function(result) { window.location.href = '{{ route("customer.dashboard") }}?payment=pending'; },
        onError: function(result) { window.location.href = '{{ route("customer.dashboard") }}?payment=failed'; },
        onClose: function() { /* User closed popup */ }
    });
});
</script>
@endpush
@endif
@endsection
