<?php

namespace App\Models;

use App\Enums\InvitationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'package_id',
        'slug',
        'status',
        'groom_name',
        'groom_father',
        'groom_mother',
        'groom_photo',
        'groom_bio',
        'groom_instagram',
        'bride_name',
        'bride_father',
        'bride_mother',
        'bride_photo',
        'bride_bio',
        'bride_instagram',
        'event_date',
        'event_time_start',
        'event_time_end',
        'event_venue',
        'event_address',
        'event_maps_url',
        'event_latitude',
        'event_longitude',
        'reception_date',
        'reception_time_start',
        'reception_time_end',
        'reception_venue',
        'reception_address',
        'reception_maps_url',
        'opening_text',
        'closing_text',
        'love_story',
        'dress_code',
        'gift_info',
        'qris_image',
        'bank_name',
        'bank_account',
        'bank_holder',
        'cover_image',
        'music_url',
        'music_autoplay',
        'primary_color',
        'secondary_color',
        'font_family',
        'custom_css',
        'is_rsvp_enabled',
        'is_guestbook_enabled',
        'is_gallery_enabled',
        'is_countdown_enabled',
        'is_music_enabled',
        'is_maps_enabled',
        'is_love_story_enabled',
        'is_gift_enabled',
        'view_count',
        'published_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => InvitationStatus::class,
            'event_date' => 'date',
            'reception_date' => 'date',
            'custom_css' => 'array',
            'music_autoplay' => 'boolean',
            'is_rsvp_enabled' => 'boolean',
            'is_guestbook_enabled' => 'boolean',
            'is_gallery_enabled' => 'boolean',
            'is_countdown_enabled' => 'boolean',
            'is_music_enabled' => 'boolean',
            'is_maps_enabled' => 'boolean',
            'is_love_story_enabled' => 'boolean',
            'is_gift_enabled' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            if (empty($invitation->slug)) {
                $invitation->slug = self::generateSlug($invitation->groom_name, $invitation->bride_name);
            }
        });
    }

    public static function generateSlug(string $groomName, string $brideName): string
    {
        $baseSlug = Str::slug($groomName . '-' . $brideName);
        $slug = $baseSlug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function guestbooks(): HasMany
    {
        return $this->hasMany(Guestbook::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class)->orderBy('sort_order');
    }

    public function loveStories(): HasMany
    {
        return $this->hasMany(LoveStory::class)->orderBy('sort_order');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getUrl(): string
    {
        return url('/' . $this->slug);
    }

    public function getPersonalUrl(string $guestName): string
    {
        return $this->getUrl() . '?to=' . urlencode($guestName);
    }

    public function isPublished(): bool
    {
        return $this->status === InvitationStatus::PUBLISHED;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function incrementView(): void
    {
        $this->increment('view_count');
    }

    public function getRsvpStats(): array
    {
        $guests = $this->guests();

        return [
            'total' => $guests->count(),
            'attending' => $guests->where('rsvp_status', 'attending')->count(),
            'not_attending' => $guests->where('rsvp_status', 'not_attending')->count(),
            'maybe' => $guests->where('rsvp_status', 'maybe')->count(),
            'pending' => $guests->where('rsvp_status', 'pending')->count(),
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', InvitationStatus::PUBLISHED);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
