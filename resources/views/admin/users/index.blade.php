@extends('layouts.dashboard')
@section('page-title', 'Kelola Users')
@section('sidebar') @include('admin._sidebar') @endsection

@section('dashboard-content')
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
        <form method="GET" class="flex items-center space-x-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..." class="flex-1 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-amber-500 outline-none text-sm">
            <select name="role" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 text-sm" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded-xl text-sm font-medium">Cari</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-gray-100 dark:border-gray-700">
                <th class="text-left p-4 font-medium text-gray-500">User</th>
                <th class="text-left p-4 font-medium text-gray-500">Role</th>
                <th class="text-left p-4 font-medium text-gray-500">Verified</th>
                <th class="text-left p-4 font-medium text-gray-500">Status</th>
                <th class="text-left p-4 font-medium text-gray-500">Joined</th>
                <th class="p-4"></th>
            </tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="p-4">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </td>
                    <td class="p-4"><span class="px-2 py-1 rounded-lg text-xs font-medium {{ $user->role->value === 'super_admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">{{ $user->role->label() }}</span></td>
                    <td class="p-4">{!! $user->isVerified() ? '<span class="text-green-600">✓</span>' : '<span class="text-red-500">✗</span>' !!}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded-lg text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="p-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="p-4">
                        <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                            @csrf
                            <button type="submit" class="text-xs text-amber-600 hover:underline">{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $users->withQueryString()->links() }}</div>
</div>
@endsection
