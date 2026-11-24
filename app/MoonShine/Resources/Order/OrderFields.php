<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Order;

use App\Enums\OrderStatus;
use App\MoonShine\Fields\FieldSet;
use App\MoonShine\Resources\User\UserFields;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;

final class OrderFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'user_id' => 'Пользователь',
        'price' => 'Стоимость',
        'status' => 'Статус',
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
            'user_id' => Select::make(self::LABELS['user_id'], 'user_id')
                ->options(static fn (): array => UserFields::options())
                ->required(),
            'price' => Number::make(self::LABELS['price'], 'price')
                ->step(0.01)
                ->required(),
            'status' => Select::make(self::LABELS['status'], 'status')
                ->options([
                    OrderStatus::ON_CONSIDER->value => 'На рассмотрении',
                    OrderStatus::IN_PROGRESS->value => 'В работе',
                    OrderStatus::COMPLETED->value => 'Завершён',
                    OrderStatus::DENIED->value => 'Отклонён',
                ])
                ->required(),
            'created_at' => Date::make(self::LABELS['created_at'], 'created_at'),
            'updated_at' => Date::make(self::LABELS['updated_at'], 'updated_at'),
        ];
    }
}
