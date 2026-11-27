<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Frame;

use App\Models\Module;
use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;

final class FrameFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'module_id' => 'Модуль',
        'max_total_weight_g' => 'Максимальная масса сборки, г',
        'max_power_output' => 'Максимальная выходная мощность',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'module_id' => Select::make(self::LABELS['module_id'], 'module_id')
                ->options(static fn (): array => Module::query()->pluck('name', 'id')->toArray())
                ->required(),
            'max_total_weight_g' => Number::make(self::LABELS['max_total_weight_g'], 'max_total_weight_g')->min(1)->required(),
            'max_power_output' => Number::make(self::LABELS['max_power_output'], 'max_power_output')->nullable(),
        ];
    }
}
