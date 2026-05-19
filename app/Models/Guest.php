<?php

namespace App\Models;

use App\Enums\RsvpStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $fillable = [
        'invitation_id',
        'name',
        'slug',
        'phone',
        'email',
        'group',
        'max_pax',
        'rsvp_status',
        'attending_count',
        'rsvp_note',
        'rsvp_at',
        'is_sent',
        'sent_at',
        'qr_code',
        'is_checked_in',
        'checked_in_at',
        'open_count',
        'last_opened_at',
    ];

    protected function casts(): array
    {
        return [
            'rsvp_status' => RsvpStatus::class,
            'rsvp_at' => 'datetime',
            'sent_at' => 'datetime',
            'checked_in_at' => 'datetime',
            'last_opened_at' => 'datetime',
            'is_sent' => 'boolean',
            'is_checked_in' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($guest) {
            if (empty($guest->slug)) {
                $guest->slug = Str::slug($guest->name);
            }
        });
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function getPersonalUrl(): string
    {
        return $this->invitation->getPersonalUrl($this->name);
    }

    public function markAsOpened(): void
    {
        $this->increment('open_count');
        $this->update(['last_opened_at' => now()]);
    }

    public function scopeAttending($query)
    {
        return $query->where('rsvp_status', RsvpStatus::ATTENDING);
    }

    public function scopePending($query)
    {
        return $query->where('rsvp_status', RsvpStatus::PENDING);
    }
}
