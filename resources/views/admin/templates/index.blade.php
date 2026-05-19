@extends('layouts.dashboard')
@section('page-title', 'Kelola Templates')
@section('sidebar') @include('admin._sidebar') @endsection

@section('dashboard-content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($templates as $template)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="h-32 bg-gradient-to-br from-amber-100 to-rose-100 flex items-center justify-center">
            <span class="text-3xl">💒</span>
        </div>
        <div class="p-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $template->name }}</h3>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $template->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $template->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
            <p class="text-sm text-gray-500 mb-3">{{ $template->description }}</p>
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>{{ $template->invitations_count }} undangan</span>
                <span class="capitalize">{{ $template->tier->value }}</span>
            </div>
            <div class="mt-4 flex space-x-2">
                <form method="POST" action="{{ route('admin.templates.toggle-active', $template) }}">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $template->is_active ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">{{ $template->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-6">{{ $templates->links() }}</div>
@endsection
