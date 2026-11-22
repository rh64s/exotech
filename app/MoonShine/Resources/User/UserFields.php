<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User;

use App\Models\Role;
use App\Models\User;
use App\MoonShine\Fields\FieldSet;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\Phone;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

final class UserFields extends FieldSet
{
    /**
     * @var array<string, string>
     */
    private const LABELS = [
        'id' => 'ID',
        'surname' => 'Фамилия',
        'name' => 'Имя',
        'patronymic' => 'Отчество',
        'phone' => 'Телефон',
        'email' => 'Email',
        'password' => 'Пароль',
        'role_id' => 'Роль',
        'email_verified_at' => 'Email подтверждён',
        'created_at' => 'Создан',
        'updated_at' => 'Обновлён',
        'blocked' => 'Заблокирован',
    ];

    /**
     * @return array<string, FieldContract>
     */
    public static function make(): array
    {
        return [
            'id' => ID::make(),
            'surname' => Text::make(self::LABELS['surname'], 'surname')->required(),
            'name' => Text::make(self::LABELS['name'], 'name')->required(),
            'patronymic' => Text::make(self::LABELS['patronymic'], 'patronymic'),
            'phone' => Phone::make(self::LABELS['phone'], 'phone')->required(),
            'email' => Email::make(self::LABELS['email'], 'email')->required(),
            'password' => Password::make(self::LABELS['password'], 'password'),
            'role_id' => Select::make(self::LABELS['role_id'], 'role_id')
                ->options(static fn (): array => Role::query()->pluck('name', 'id')->toArray()),
            'email_verified_at' => Date::make(self::LABELS['email_verified_at'], 'email_verified_at'),
            'created_at' => Date::make(self::LABELS['created_at'], 'created_at'),
            'updated_at' => Date::make(self::LABELS['updated_at'], 'updated_at'),
            'blocked' => Switcher::make(self::LABELS['blocked'], 'blocked'
            )->required(),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return User::query()
            ->orderBy('surname')
            ->get()
            ->mapWithKeys(static fn (User $user): array => [
                $user->id => trim("{$user->surname} {$user->name}"),
            ])
            ->all();
    }
}
