<?php

namespace App\Enums;

enum AttachmentInterfaceType: string
{
    case Mechanical = 'mechanical';
    case Electrical = 'electrical';
    case Other = 'other';

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
