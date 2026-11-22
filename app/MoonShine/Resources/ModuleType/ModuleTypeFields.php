<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ModuleType;

use App\Models\ModuleCategory;
use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

final class ModuleTypeFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'name' => 'Название',
        'description' => 'Описание',
        'category_id' => 'Категория',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'name' => Text::make(self::LABELS['name'], 'name')->required(),
            'description' => Textarea::make(self::LABELS['description'], 'description'),
            'category_id' => Select::make(self::LABELS['category_id'], 'category_id')
                ->options(static fn (): array => ModuleCategory::query()->pluck('name', 'id')->toArray())
                ->required(),
        ];
    }
}
