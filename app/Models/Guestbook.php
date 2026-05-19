<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guestbook extends Model
{
    protected $fillable = [
        'invitation_id',
        'name',
        'message',
        'is_approved',
        'is_spam',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_spam' => 'boolean',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true)->where('is_spam', false);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false)->where('is_spam', false);
    }
}
