@extends('layouts.auth')
@section('auth-content')
<div x-data="otpForm()" class="text-center">
    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center mb-6">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-2">Verifikasi Email</h2>
    <p class="text-gray-600 mb-2">Masukkan kode 6 digit yang dikirim ke</p>
    <p class="text-amber-600 font-semibold mb-8">{{ $email }}</p>

    @if($errors->has('code'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
            <span class="text-sm text-red-700">{{ $errors->first('code') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
            <span class="text-sm text-green-700">{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('verification.otp.verify') }}" @submit="submitForm($event)">
        @csrf
        <input type="hidden" name="code" :value="otp.join('')">

        <!-- OTP Inputs -->
        <div class="flex justify-center space-x-3 mb-8">
            <template x-for="(digit, index) in otp" :key="index">
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                       :id="'otp-' + index"
                       x-model="otp[index]"
                       @input="handleInput(index, $event)"
                       @keydown.backspace="handleBackspace(index, $event)"
                       @paste="handlePaste($event)"
                       class="w-12 h-14 sm:w-14 sm:h-16 text-center text-2xl font-bold rounded-2xl border-2 transition-all duration-200 outline-none"
                       :class="otp[index] ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-200 bg-gray-50 focus:border-amber-500 focus:bg-white'">
            </template>
        </div>

        <button type="submit" :disabled="!isComplete"
                class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold rounded-2xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none">
            Verifikasi
        </button>
    </form>

    <!-- Resend OTP -->
    <div class="mt-6">
        <p class="text-sm text-gray-600 mb-3">Tidak menerima kode?</p>
        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <button type="submit" :disabled="cooldown > 0"
                    class="text-sm font-semibold text-amber-600 hover:text-amber-700 disabled:text-gray-400 disabled:cursor-not-allowed transition-colors">
                <span x-show="cooldown > 0">Kirim ulang dalam <span x-text="cooldown"></span> detik</span>
                <span x-show="cooldown <= 0">Kirim Ulang Kode</span>
            </button>
        </form>
    </div>

    <div class="mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Keluar dari akun</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function otpForm() {
    return {
        otp: ['', '', '', '', '', ''],
        cooldown: {{ $cooldown ?? 0 }},
        init() {
            if (this.cooldown > 0) {
                this.startCountdown();
            }
            this.$nextTick(() => document.getElementById('otp-0')?.focus());
        },
        get isComplete() {
            return this.otp.every(d => d !== '');
        },
        handleInput(index, event) {
            const value = event.target.value.replace(/\D/g, '');
            this.otp[index] = value.slice(-1);
            event.target.value = this.otp[index];
            if (value && index < 5) {
                document.getElementById('otp-' + (index + 1))?.focus();
            }
        },
        handleBackspace(index, event) {
            if (!this.otp[index] && index > 0) {
                document.getElementById('otp-' + (index - 1))?.focus();
            }
        },
        handlePaste(event) {
            event.preventDefault();
            const paste = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            paste.split('').forEach((char, i) => { this.otp[i] = char; });
            const nextEmpty = this.otp.findIndex(d => d === '');
            const focusIndex = nextEmpty === -1 ? 5 : nextEmpty;
            document.getElementById('otp-' + focusIndex)?.focus();
        },
        submitForm(event) {
            if (!this.isComplete) event.preventDefault();
        },
        startCountdown() {
            const interval = setInterval(() => {
                this.cooldown--;
                if (this.cooldown <= 0) clearInterval(interval);
            }, 1000);
        }
    };
}
</script>
@endpush
