<?php

namespace App\Enums;

enum CharacteristicsType: string
{
    case String = 'string';
    case Integer = 'int';
    case Boolean = 'bool';
    case Float = 'float';

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
