<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\BodyZone;

use App\Models\BodyZone;
use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

final class BodyZoneFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'name' => 'Название',
        'parent_id' => 'Родительская зона',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'name' => Text::make(self::LABELS['name'], 'name')->required(),
            'parent_id' => Select::make(self::LABELS['parent_id'], 'parent_id')
                ->options(static fn (): array => BodyZone::query()->pluck('name', 'id')->toArray())
                ->nullable(),
        ];
    }
}
