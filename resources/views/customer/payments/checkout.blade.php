@extends('layouts.dashboard')
@section('page-title', 'Checkout')
@section('sidebar') @include('customer._sidebar') @endsection

@section('dashboard-content')
<div class="max-w-lg mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Ringkasan Pesanan</h3>
        <div class="border-t border-gray-100 dark:border-gray-700 my-6"></div>

        <div class="space-y-4 mb-6">
            <div class="flex justify-between">
                <span class="text-gray-600">Paket</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $package->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Durasi</span>
                <span class="text-gray-900 dark:text-white">{{ $package->duration_days }} hari</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Harga</span>
                <span class="text-gray-900 dark:text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
            </div>
            @if($package->discount_price)
            <div class="flex justify-between text-green-600">
                <span>Diskon</span>
                <span>- Rp {{ number_format($package->price - $package->discount_price, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between">
                <span class="font-bold text-gray-900 dark:text-white">Total</span>
                <span class="text-xl font-bold text-amber-600">{{ $package->getFormattedPrice() }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('customer.checkout.process', $package) }}">
            @csrf
            @if($invitation)
                <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
            @endif
            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/25 hover:from-amber-600 hover:to-amber-700 transition-all">
                Bayar Sekarang
            </button>
        </form>

        <p class="text-xs text-gray-500 text-center mt-4">Pembayaran diproses aman melalui Midtrans</p>
    </div>
</div>
@endsection
