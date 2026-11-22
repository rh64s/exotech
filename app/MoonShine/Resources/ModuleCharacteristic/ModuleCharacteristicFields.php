<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ModuleCharacteristic;

use App\Models\Characteristic;
use App\Models\Module;
use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Textarea;

final class ModuleCharacteristicFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'value' => 'Значение',
        'module_id' => 'Модуль',
        'characteristic_id' => 'Характеристика',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'value' => Textarea::make(self::LABELS['value'], 'value')->required(),
            'module_id' => Select::make(self::LABELS['module_id'], 'module_id')
                ->options(static fn (): array => Module::query()->pluck('name', 'id')->toArray())
                ->required(),
            'characteristic_id' => Select::make(self::LABELS['characteristic_id'], 'characteristic_id')
                ->options(static fn (): array => Characteristic::query()->pluck('name', 'id')->toArray())
                ->required(),
        ];
    }
}
