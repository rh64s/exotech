<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Characteristic;

use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

final class CharacteristicFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'name' => 'Название',
        'unit' => 'Единица измерения',
        'data_type' => 'Тип данных',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'name' => Text::make(self::LABELS['name'], 'name')->required(),
            'unit' => Text::make(self::LABELS['unit'], 'unit'),
            'data_type' => Select::make(self::LABELS['data_type'], 'data_type')
                ->options([
                    'string' => 'Строка',
                    'number' => 'Число',
                    'boolean' => 'Логическое',
                ])
                ->required(),
        ];
    }
}
