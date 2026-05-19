@extends('layouts.auth')
@section('auth-content')
<div>
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Lupa Password</h2>
    <p class="text-gray-600 mb-8">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>

    @if(session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
            <span class="text-sm text-green-700">{{ session('status') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
            <span class="text-sm text-red-700">{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200 outline-none bg-gray-50 hover:bg-white"
                   placeholder="nama@email.com">
        </div>

        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold rounded-2xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all duration-200 transform hover:scale-[1.02]">
            Kirim Link Reset
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-gray-600">
        Ingat password? <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 font-semibold">Masuk</a>
    </p>
</div>
@endsection
