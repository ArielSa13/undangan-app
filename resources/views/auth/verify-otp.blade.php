@extends('layouts.auth')
@section('auth-content')
<div x-data="otpForm()" class="text-center">
    <!-- Icon with animated ring -->
    <div class="relative w-20 h-20 mx-auto mb-8">
        <div class="absolute inset-0 bg-amber-400/20 rounded-full animate-ping" style="animation-duration: 2s;"></div>
        <div class="relative w-20 h-20 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center shadow-xl shadow-amber-500/30">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
        </div>
    </div>

    <!-- Title -->
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">Verifikasi Email Anda</h2>
    <p class="text-gray-500 mb-1 text-sm sm:text-base">Kami telah mengirim kode verifikasi 6 digit ke</p>
    <div class="inline-flex items-center space-x-2 bg-amber-50 border border-amber-100 rounded-xl px-4 py-2 mb-8">
        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <span class="text-amber-700 font-semibold text-sm">{{ $email }}</span>
    </div>

    <!-- Error Message -->
    @if($errors->has('code'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center space-x-3">
            <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-sm text-red-700 font-medium">{{ $errors->first('code') }}</span>
        </div>
    @endif

    @if($errors->has('resend'))
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-100 rounded-2xl flex items-center space-x-3">
            <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-sm text-yellow-700 font-medium">{{ $errors->first('resend') }}</span>
        </div>
    @endif

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-2xl flex items-center space-x-3">
            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-sm text-green-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- OTP Form -->
    <form method="POST" action="{{ route('verification.otp.verify') }}" @submit="submitForm($event)">
        @csrf
        <input type="hidden" name="code" :value="otp.join('')">

        <!-- OTP Input Boxes -->
        <div class="flex justify-center gap-2 sm:gap-3 mb-8">
            <template x-for="(digit, index) in otp" :key="index">
                <div class="relative">
                    <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]"
                           :id="'otp-' + index"
                           x-model="otp[index]"
                           @input="handleInput(index, $event)"
                           @keydown.backspace="handleBackspace(index, $event)"
                           @paste="handlePaste($event)"
                           @focus="$event.target.select()"
                           class="w-11 h-14 sm:w-14 sm:h-16 text-center text-xl sm:text-2xl font-bold rounded-xl sm:rounded-2xl border-2 transition-all duration-300 outline-none shadow-sm"
                           :class="otp[index]
                               ? 'border-amber-500 bg-amber-50 text-amber-800 shadow-amber-500/10 scale-105'
                               : 'border-gray-200 bg-white text-gray-900 hover:border-gray-300 focus:border-amber-500 focus:shadow-amber-500/10 focus:bg-amber-50/50'">
                    <!-- Active indicator dot -->
                    <div x-show="otp[index]" class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-amber-500 rounded-full"></div>
                </div>
            </template>
        </div>

        <!-- Progress indicator -->
        <div class="mb-6">
            <div class="flex items-center justify-center space-x-1.5">
                <template x-for="(digit, index) in otp" :key="'dot-' + index">
                    <div class="w-2 h-2 rounded-full transition-all duration-300"
                         :class="otp[index] ? 'bg-amber-500 scale-110' : 'bg-gray-200'"></div>
                </template>
            </div>
            <p class="text-xs text-gray-400 mt-2" x-show="!isComplete">Masukkan <span x-text="6 - otp.filter(d => d !== '').length"></span> digit lagi</p>
            <p class="text-xs text-green-600 font-medium mt-2" x-show="isComplete">
                <svg class="w-3.5 h-3.5 inline -mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Kode lengkap! Klik verifikasi.
            </p>
        </div>

        <!-- Submit Button -->
        <button type="submit" :disabled="!isComplete"
                class="w-full py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-2xl shadow-lg transition-all duration-300 relative overflow-hidden group"
                :class="isComplete
                    ? 'hover:from-amber-600 hover:to-amber-700 shadow-amber-500/30 hover:shadow-amber-500/50 transform hover:scale-[1.02] hover:-translate-y-0.5'
                    : 'opacity-40 cursor-not-allowed shadow-none'">
            <span class="relative z-10 flex items-center justify-center space-x-2">
                <svg x-show="!isComplete" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <svg x-show="isComplete" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span x-text="isComplete ? 'Verifikasi Sekarang' : 'Masukkan Kode OTP'"></span>
            </span>
            <!-- Shine effect on hover -->
            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
        <div class="relative flex justify-center"><span class="px-4 bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">atau</span></div>
    </div>

    <!-- Resend OTP Section -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-center space-x-2 mb-3">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <p class="text-sm text-gray-600">Tidak menerima kode?</p>
        </div>

        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <button type="submit" :disabled="cooldown > 0"
                    class="w-full py-3 rounded-xl text-sm font-semibold transition-all duration-300"
                    :class="cooldown > 0
                        ? 'bg-gray-50 text-gray-400 cursor-not-allowed border border-gray-100'
                        : 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 hover:border-amber-300 hover:shadow-sm'">
                <span x-show="cooldown > 0" class="flex items-center justify-center space-x-2">
                    <!-- Circular countdown -->
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Kirim ulang dalam <span x-text="cooldown" class="font-bold tabular-nums"></span> detik</span>
                </span>
                <span x-show="cooldown <= 0" class="flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Kirim Ulang Kode OTP</span>
                </span>
            </button>
        </form>

        <p class="text-xs text-gray-400 mt-3">Periksa juga folder spam/junk email Anda</p>
    </div>

    <!-- Logout link -->
    <div class="mt-8 pt-6 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center space-x-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Gunakan akun lain</span>
            </button>
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
            this.$nextTick(() => {
                setTimeout(() => document.getElementById('otp-0')?.focus(), 100);
            });
        },
        get isComplete() {
            return this.otp.every(d => d !== '');
        },
        handleInput(index, event) {
            const value = event.target.value.replace(/\D/g, '');
            this.otp[index] = value.slice(-1);
            event.target.value = this.otp[index];

            if (value && index < 5) {
                this.$nextTick(() => {
                    document.getElementById('otp-' + (index + 1))?.focus();
                });
            }

            // Auto-submit when complete
            if (this.isComplete) {
                this.$nextTick(() => {
                    // Small delay for visual feedback
                    setTimeout(() => {
                        this.$el.closest('form')?.requestSubmit();
                    }, 300);
                });
            }
        },
        handleBackspace(index, event) {
            if (!this.otp[index] && index > 0) {
                this.otp[index - 1] = '';
                this.$nextTick(() => {
                    document.getElementById('otp-' + (index - 1))?.focus();
                });
            }
        },
        handlePaste(event) {
            event.preventDefault();
            const paste = event.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            paste.split('').forEach((char, i) => {
                this.otp[i] = char;
            });
            const nextEmpty = this.otp.findIndex(d => d === '');
            const focusIndex = nextEmpty === -1 ? 5 : nextEmpty;
            this.$nextTick(() => {
                document.getElementById('otp-' + focusIndex)?.focus();
            });
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
@endsection
