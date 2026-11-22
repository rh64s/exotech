<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Scheme;

use App\MoonShine\Fields\FieldSet;
use App\MoonShine\Resources\User\UserFields;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

final class SchemeFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'user_id' => 'Пользователь',
        'name' => 'Название',
        'description' => 'Описание',
        'official' => 'Официальная',
        'completed' => 'Завершена',
        'created_at' => 'Создана',
        'updated_at' => 'Обновлена',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'user_id' => Select::make(self::LABELS['user_id'], 'user_id')
                ->options(static fn (): array => UserFields::options())
                ->nullable(),
            'name' => Text::make(self::LABELS['name'], 'name')->required(),
            'description' => Textarea::make(self::LABELS['description'], 'description')->required(),
            'official' => Switcher::make(self::LABELS['official'], 'official'),
            'completed' => Switcher::make(self::LABELS['completed'], 'completed'),
            'created_at' => Date::make(self::LABELS['created_at'], 'created_at'),
            'updated_at' => Date::make(self::LABELS['updated_at'], 'updated_at'),
        ];
    }
}
