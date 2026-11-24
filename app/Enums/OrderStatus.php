<?php

namespace App\Enums;

enum OrderStatus: string
{
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case DENIED = 'denied';
    case ON_CONSIDER = 'consider';

    /**
     * Get all enum values.
     *
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case): string => $case->value, self::cases());
    }
}
