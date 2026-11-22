<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Message;

use App\Models\Chat;
use App\MoonShine\Fields\FieldSet;
use App\MoonShine\Resources\User\UserFields;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Textarea;

final class MessageFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'content' => 'Содержание',
        'user_id' => 'Пользователь',
        'chat_id' => 'Чат',
        'created_at' => 'Создано',
        'updated_at' => 'Обновлено',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'content' => Textarea::make(self::LABELS['content'], 'content')->required(),
            'user_id' => Select::make(self::LABELS['user_id'], 'user_id')
                ->options(static fn (): array => UserFields::options())
                ->nullable(),
            'chat_id' => Select::make(self::LABELS['chat_id'], 'chat_id')
                ->options(static fn (): array => Chat::query()->pluck('name', 'id')->toArray())
                ->required(),
            'created_at' => Date::make(self::LABELS['created_at'], 'created_at'),
            'updated_at' => Date::make(self::LABELS['updated_at'], 'updated_at'),
        ];
    }
}
