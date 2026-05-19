<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Package;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService,
    ) {}

    public function packages(): View
    {
        $packages = Package::active()->get();
        return view('customer.payments.packages', compact('packages'));
    }

    public function checkout(Request $request, Package $package): View
    {
        $user = $request->user();
        $invitation = null;

        if ($request->has('invitation_id')) {
            $invitation = Invitation::where('id', $request->invitation_id)
                ->where('user_id', $user->id)
                ->first();
        }

        return view('customer.payments.checkout', compact('package', 'invitation'));
    }

    public function process(Request $request, Package $package): RedirectResponse
    {
        $user = $request->user();
        $invitation = null;

        if ($request->has('invitation_id')) {
            $invitation = Invitation::where('id', $request->invitation_id)
                ->where('user_id', $user->id)
                ->first();
        }

        $payment = $this->paymentService->createPayment($user, $package, $invitation);

        if ($payment->snap_token) {
            return redirect()->route('customer.payments.pay', $payment);
        }

        return back()->withErrors(['payment' => 'Gagal membuat pembayaran. Silakan coba lagi.']);
    }

    public function pay(\App\Models\Payment $payment): View
    {
        return view('customer.payments.pay', compact('payment'));
    }

    public function history(Request $request): View
    {
        $payments = $request->user()
            ->payments()
            ->with('package')
            ->latest()
            ->paginate(10);

        return view('customer.payments.history', compact('payments'));
    }
}
