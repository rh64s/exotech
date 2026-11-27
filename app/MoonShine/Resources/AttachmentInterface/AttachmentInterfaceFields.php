<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\AttachmentInterface;

use App\Enums\AttachmentInterfaceType;
use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

final class AttachmentInterfaceFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'name' => 'Название',
        'type' => 'Тип',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        $tempNames = AttachmentInterfaceType::values();

        return [
            'id' => ID::make(),
            'name' => Text::make(self::LABELS['name'], 'name')->required(),
            'type' => Enum::make(self::LABELS['type'], 'type')
                ->attach(AttachmentInterfaceType::class)
                ->options([
                    AttachmentInterfaceType::Mechanical->value => 'Механический',
                    AttachmentInterfaceType::Electrical->value => 'Электрический',
                    AttachmentInterfaceType::Other->value => 'Другой',
                ])
                ->required(),
        ];
    }
}
