<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'invitation_id',
        'package_id',
        'order_id',
        'transaction_id',
        'amount',
        'discount_amount',
        'total_amount',
        'status',
        'payment_type',
        'payment_channel',
        'midtrans_response',
        'snap_token',
        'redirect_url',
        'paid_at',
        'expired_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => PaymentStatus::class,
            'midtrans_response' => 'array',
            'paid_at' => 'datetime',
            'expired_at' => 'datetime',
            'amount' => 'integer',
            'discount_amount' => 'integer',
            'total_amount' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function isPaid(): bool
    {
        return $this->status === PaymentStatus::PAID;
    }

    public function isPending(): bool
    {
        return $this->status === PaymentStatus::PENDING;
    }

    public function getFormattedAmount(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function scopePaid($query)
    {
        return $query->where('status', PaymentStatus::PAID);
    }

    public function scopePending($query)
    {
        return $query->where('status', PaymentStatus::PENDING);
    }
}
