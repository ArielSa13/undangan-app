<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoveStory extends Model
{
    protected $fillable = [
        'invitation_id',
        'title',
        'date',
        'description',
        'image',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
