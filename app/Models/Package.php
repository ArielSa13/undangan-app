<?php

namespace App\Models;

use App\Enums\PackageTier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'tier',
        'description',
        'price',
        'discount_price',
        'duration_days',
        'max_photos',
        'max_guests',
        'max_templates',
        'has_rsvp',
        'has_music',
        'has_guestbook',
        'has_gallery',
        'has_countdown',
        'has_maps',
        'has_love_story',
        'has_digital_envelope',
        'has_qr_checkin',
        'has_custom_domain',
        'has_analytics',
        'has_whatsapp_blast',
        'is_active',
        'sort_order',
        'features',
    ];

    protected function casts(): array
    {
        return [
            'tier' => PackageTier::class,
            'price' => 'integer',
            'discount_price' => 'integer',
            'features' => 'array',
            'has_rsvp' => 'boolean',
            'has_music' => 'boolean',
            'has_guestbook' => 'boolean',
            'has_gallery' => 'boolean',
            'has_countdown' => 'boolean',
            'has_maps' => 'boolean',
            'has_love_story' => 'boolean',
            'has_digital_envelope' => 'boolean',
            'has_qr_checkin' => 'boolean',
            'has_custom_domain' => 'boolean',
            'has_analytics' => 'boolean',
            'has_whatsapp_blast' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function getEffectivePrice(): int
    {
        return $this->discount_price ?? $this->price;
    }

    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->getEffectivePrice(), 0, ',', '.');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
