<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $fillable = [
        'invitation_id',
        'image_path',
        'thumbnail_path',
        'caption',
        'sort_order',
        'file_size',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function getImageUrl(): string
    {
        return Storage::url($this->image_path);
    }

    public function getThumbnailUrl(): string
    {
        return Storage::url($this->thumbnail_path ?? $this->image_path);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
