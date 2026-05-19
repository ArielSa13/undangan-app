@extends('layouts.dashboard')
@section('page-title', 'Pilih Paket')
@section('sidebar') @include('customer._sidebar') @endsection

@section('dashboard-content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl">
    @foreach($packages as $package)
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl border {{ $package->tier->value === 'premium' ? 'border-amber-300 ring-2 ring-amber-400' : 'border-gray-100 dark:border-gray-700' }} p-6 flex flex-col">
        @if($package->tier->value === 'premium')
        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-amber-500 text-white text-xs font-bold rounded-full">POPULER</div>
        @endif
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $package->name }}</h3>
        <p class="text-sm text-gray-500 mb-4">{{ $package->description }}</p>
        <div class="mb-4">
            @if($package->discount_price)
                <span class="text-sm text-gray-400 line-through">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
            @endif
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $package->getFormattedPrice() }}<span class="text-sm text-gray-500 font-normal">/tahun</span></p>
        </div>
        <ul class="space-y-2 mb-6 flex-1">
            @foreach($package->features ?? [] as $feature)
            <li class="flex items-start space-x-2 text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                <span>{{ $feature }}</span>
            </li>
            @endforeach
        </ul>
        <a href="{{ route('customer.checkout', $package) }}" class="block w-full text-center py-3 rounded-xl font-semibold transition-all {{ $package->tier->value === 'premium' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/25' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200' }}">
            Pilih Paket
        </a>
    </div>
    @endforeach
</div>
@endsection
