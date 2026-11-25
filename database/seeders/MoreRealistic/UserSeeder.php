<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = Role::pluck('id', 'name');
        foreach ([
            ['anna', 'Анна', 'Белова', 'Сергеевна', 'client'],
            ['igor', 'Игорь', 'Мельников', 'Олегович', 'client'],
            ['elena', 'Елена', 'Соколова', 'Игоревна', 'expert'],
        ] as [$login, $name, $surname, $patronymic, $role]) {
            User::firstOrCreate(['email' => "$login@example.test"], [
                'name' => $name, 'surname' => $surname, 'patronymic' => $patronymic,
                'password' => 'password', 'email_verified_at' => now(), 'role_id' => $roles[$role],
            ]);
        }
    }
}
