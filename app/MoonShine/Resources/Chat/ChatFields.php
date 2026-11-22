<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Chat;

use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

final class ChatFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'name' => 'Название',
        'need_expert_help' => 'Нужна помощь эксперта',
        'is_active' => 'Активен',
        'created_at' => 'Создан',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'name' => Text::make(self::LABELS['name'], 'name'),
            'need_expert_help' => Switcher::make(self::LABELS['need_expert_help'], 'need_expert_help'),
            'is_active' => Switcher::make(self::LABELS['is_active'], 'is_active'),
            'created_at' => Date::make(self::LABELS['created_at'], 'created_at'),
        ];
    }
}
