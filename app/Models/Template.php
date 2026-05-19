<?php

namespace App\Models;

use App\Enums\PackageTier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'preview_url',
        'category',
        'tier',
        'color_scheme',
        'fonts',
        'blade_path',
        'is_active',
        'is_premium',
        'sort_order',
        'usage_count',
    ];

    protected function casts(): array
    {
        return [
            'tier' => PackageTier::class,
            'color_scheme' => 'array',
            'fonts' => 'array',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
        ];
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeForTier($query, PackageTier $tier)
    {
        $tiers = match ($tier) {
            PackageTier::EXCLUSIVE => [PackageTier::BASIC, PackageTier::PREMIUM, PackageTier::EXCLUSIVE],
            PackageTier::PREMIUM => [PackageTier::BASIC, PackageTier::PREMIUM],
            PackageTier::BASIC => [PackageTier::BASIC],
        };

        return $query->whereIn('tier', $tiers);
    }
}
