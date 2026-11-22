<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use InvalidArgumentException;
use MoonShine\Contracts\UI\FieldContract;

abstract class FieldSet
{
    /**
     * @return array<string, FieldContract>
     */
    abstract public static function make(): array;

    /**
     * Select fields by key, preserving the requested order.
     *
     * @param  list<string>  $names
     * @return list<FieldContract>
     */
    public static function only(array $names): array
    {
        $all = static::make();
        $fields = [];

        foreach ($names as $name) {
            if (! array_key_exists($name, $all)) {
                throw new InvalidArgumentException(
                    'Unknown '.class_basename(static::class)." field [{$name}]."
                );
            }

            $fields[] = $all[$name];
        }

        return $fields;
    }
}
