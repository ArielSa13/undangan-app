<?php

namespace App\Enums;

enum RsvpStatus: string
{
    case PENDING = 'pending';
    case ATTENDING = 'attending';
    case NOT_ATTENDING = 'not_attending';
    case MAYBE = 'maybe';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ATTENDING => 'Hadir',
            self::NOT_ATTENDING => 'Tidak Hadir',
            self::MAYBE => 'Mungkin Hadir',
        };
    }
}
