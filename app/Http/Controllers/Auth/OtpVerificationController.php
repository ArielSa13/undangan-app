<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function __construct(
        private OtpService $otpService,
    ) {}

    public function show(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user->isVerified()) {
            return redirect()->route('customer.dashboard');
        }

        $cooldown = 0;
        if (!$this->otpService->canResend($user)) {
            $cooldown = $this->otpService->getResendCooldown($user);
        }

        return view('auth.verify-otp', [
            'email' => $user->email,
            'cooldown' => $cooldown,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();
        $result = $this->otpService->verify($user, $request->code);

        if (!$result['success']) {
            return back()->withErrors(['code' => $result['message']]);
        }

        // Redirect to dashboard
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Email berhasil diverifikasi!');
        }

        return redirect()->route('customer.dashboard')
            ->with('success', 'Email berhasil diverifikasi! Selamat datang.');
    }

    public function resend(): RedirectResponse
    {
        $user = Auth::user();
        $result = $this->otpService->resend($user);

        if (!$result['success']) {
            return back()->withErrors(['resend' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }
}
