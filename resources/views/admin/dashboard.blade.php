@extends('layouts.dashboard')
@section('page-title', 'Admin Dashboard')

@section('sidebar')
@include('admin._sidebar')
@endsection

@section('dashboard-content')
<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users']) }}</p>
        <p class="text-sm text-gray-500">Total Users</p>
        <p class="text-xs text-green-600 mt-1">+{{ $stats['new_users_today'] }} hari ini</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_invitations']) }}</p>
        <p class="text-sm text-gray-500">Total Undangan</p>
        <p class="text-xs text-gray-500 mt-1">{{ $stats['published_invitations'] }} published</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500">Total Revenue</p>
        <p class="text-xs text-yellow-600 mt-1">{{ $stats['pending_payments'] }} pending</p>
    </div>
</div>

<!-- Recent Payments -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <div class="p-5 border-b border-gray-100 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">Pembayaran Terbaru</h3>
        </div>
        <div class="p-5 space-y-3">
            @forelse($recentPayments as $payment)
            <div class="flex items-center justify-between py-2">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $payment->user->name ?? '-' }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->package->name ?? '-' }} &bull; {{ $payment->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold {{ $payment->status->value === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">{{ $payment->getFormattedAmount() }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->status->label() }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">Belum ada pembayaran</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <div class="p-5 border-b border-gray-100 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">User Terbaru</h3>
        </div>
        <div class="p-5 space-y-3">
            @forelse($recentUsers as $user)
            <div class="flex items-center space-x-3 py-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email }} &bull; {{ $user->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">Belum ada user</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
