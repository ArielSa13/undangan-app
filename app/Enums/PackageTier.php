<?php

namespace App\Enums;

enum PackageTier: string
{
    case BASIC = 'basic';
    case PREMIUM = 'premium';
    case EXCLUSIVE = 'exclusive';

    public function label(): string
    {
        return match ($this) {
            self::BASIC => 'Basic',
            self::PREMIUM => 'Premium',
            self::EXCLUSIVE => 'Exclusive',
        };
    }
}
