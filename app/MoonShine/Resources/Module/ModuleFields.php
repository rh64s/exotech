<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Module;

use App\Models\AttachmentInterface;
use App\Models\BodyZone;
use App\Models\ModuleType;
use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

final class ModuleFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'name' => 'Название',
        'description' => 'Описание',
        'price' => 'Стоимость',
        'module_type_id' => 'Тип модуля',
        'attachment_interface_id' => 'Интерфейс крепления',
        'body_zone_id' => 'Зона тела',
        'created_at' => 'Создан',
        'updated_at' => 'Обновлён',
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
            'price' => Number::make(self::LABELS['price'], 'price')
                ->step(0.01)
                ->required(),
            'module_type_id' => Select::make(self::LABELS['module_type_id'], 'module_type_id')
                ->options(static fn (): array => ModuleType::query()->pluck('name', 'id')->toArray())
                ->required(),
            'attachment_interface_id' => Select::make(self::LABELS['attachment_interface_id'], 'attachment_interface_id')
                ->options(static fn (): array => AttachmentInterface::query()->pluck('name', 'id')->toArray())
                ->required(),
            'body_zone_id' => Select::make(self::LABELS['body_zone_id'], 'body_zone_id')
                ->options(static fn (): array => BodyZone::query()->pluck('name', 'id')->toArray())
                ->nullable(),
            'created_at' => Date::make(self::LABELS['created_at'], 'created_at'),
            'updated_at' => Date::make(self::LABELS['updated_at'], 'updated_at'),
        ];
    }
}
