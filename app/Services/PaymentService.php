<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createPayment(User $user, Package $package, ?Invitation $invitation = null): Payment
    {
        $orderId = 'INV-' . strtoupper(Str::random(8)) . '-' . time();
        $amount = $package->getEffectivePrice();

        $payment = Payment::create([
            'user_id' => $user->id,
            'invitation_id' => $invitation?->id,
            'package_id' => $package->id,
            'order_id' => $orderId,
            'amount' => $package->price,
            'discount_amount' => $package->discount_price ? ($package->price - $package->discount_price) : 0,
            'total_amount' => $amount,
            'status' => PaymentStatus::PENDING,
            'expired_at' => now()->addHours(24),
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => $package->slug,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Paket ' . $package->name,
                ],
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 24,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $payment->update([
                'snap_token' => $snapToken,
                'redirect_url' => Snap::getSnapUrl($params),
            ]);
        } catch (\Exception $e) {
            $payment->update([
                'status' => PaymentStatus::FAILED,
                'notes' => $e->getMessage(),
            ]);
        }

        return $payment;
    }

    public function handleNotification(array $notification): Payment
    {
        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $fraudStatus = $notification['fraud_status'] ?? null;
        $paymentType = $notification['payment_type'] ?? null;

        $payment = Payment::where('order_id', $orderId)->firstOrFail();

        $payment->update([
            'transaction_id' => $notification['transaction_id'] ?? null,
            'payment_type' => $paymentType,
            'midtrans_response' => $notification,
        ]);

        $status = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => PaymentStatus::PAID,
            $transactionStatus === 'settlement' => PaymentStatus::PAID,
            in_array($transactionStatus, ['deny', 'cancel']) => PaymentStatus::FAILED,
            $transactionStatus === 'expire' => PaymentStatus::EXPIRED,
            $transactionStatus === 'refund' => PaymentStatus::REFUNDED,
            default => PaymentStatus::PENDING,
        };

        $payment->update(['status' => $status]);

        if ($status === PaymentStatus::PAID) {
            $payment->update(['paid_at' => now()]);
            $this->activateInvitation($payment);
        }

        return $payment;
    }

    private function activateInvitation(Payment $payment): void
    {
        if ($payment->invitation_id) {
            $invitation = $payment->invitation;
            $package = $payment->package;

            $invitation->update([
                'package_id' => $package->id,
                'expires_at' => now()->addDays($package->duration_days),
            ]);
        }
    }
}
