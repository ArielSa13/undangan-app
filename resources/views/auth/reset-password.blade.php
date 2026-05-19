@extends('layouts.auth')
@section('auth-content')
<div>
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Reset Password</h2>
    <p class="text-gray-600 mb-8">Buat password baru untuk akun Anda.</p>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-700">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required
                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200 outline-none bg-gray-50 hover:bg-white">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200 outline-none bg-gray-50 hover:bg-white"
                   placeholder="Minimal 8 karakter">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200 outline-none bg-gray-50 hover:bg-white"
                   placeholder="Ulangi password baru">
        </div>

        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold rounded-2xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all duration-200 transform hover:scale-[1.02]">
            Reset Password
        </button>
    </form>
</div>
@endsection
