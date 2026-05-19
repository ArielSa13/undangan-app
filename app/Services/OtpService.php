<?php

namespace App\Services;

use App\Jobs\SendOtpEmail;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class OtpService
{
    private const OTP_EXPIRY_MINUTES = 10;
    private const MAX_ATTEMPTS = 5;
    private const RESEND_COOLDOWN_SECONDS = 60;

    public function generate(User $user): EmailOtp
    {
        // Invalidate previous OTPs
        EmailOtp::where('user_id', $user->id)
            ->whereNull('verified_at')
            ->delete();

        $otp = EmailOtp::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'code' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'expires_at' => now()->addMinutes(self::OTP_EXPIRY_MINUTES),
            'attempt_count' => 0,
        ]);

        // Dispatch email via queue
        SendOtpEmail::dispatch($user, $otp->code);

        return $otp;
    }

    public function verify(User $user, string $code): array
    {
        $otp = EmailOtp::where('user_id', $user->id)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otp) {
            return ['success' => false, 'message' => 'Kode OTP tidak ditemukan. Silakan minta kode baru.'];
        }

        if ($otp->isExpired()) {
            return ['success' => false, 'message' => 'Kode OTP telah kadaluarsa. Silakan minta kode baru.'];
        }

        if ($otp->hasExceededAttempts(self::MAX_ATTEMPTS)) {
            return ['success' => false, 'message' => 'Terlalu banyak percobaan. Silakan minta kode baru.'];
        }

        if ($otp->code !== $code) {
            $otp->incrementAttempt();
            $remaining = self::MAX_ATTEMPTS - $otp->attempt_count;
            return ['success' => false, 'message' => "Kode OTP salah. Sisa percobaan: {$remaining}"];
        }

        // Mark OTP as verified
        $otp->update(['verified_at' => now()]);

        // Verify user email
        $user->update(['email_verified_at' => now()]);

        return ['success' => true, 'message' => 'Email berhasil diverifikasi.'];
    }

    public function canResend(User $user): bool
    {
        $key = 'otp-resend:' . $user->id;
        return !RateLimiter::tooManyAttempts($key, 1);
    }

    public function getResendCooldown(User $user): int
    {
        $key = 'otp-resend:' . $user->id;
        return RateLimiter::availableIn($key);
    }

    public function resend(User $user): array
    {
        $key = 'otp-resend:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            return [
                'success' => false,
                'message' => "Tunggu {$seconds} detik sebelum mengirim ulang.",
                'cooldown' => $seconds,
            ];
        }

        RateLimiter::hit($key, self::RESEND_COOLDOWN_SECONDS);

        $this->generate($user);

        return ['success' => true, 'message' => 'Kode OTP baru telah dikirim ke email Anda.'];
    }
}
