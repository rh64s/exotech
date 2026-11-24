<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::query()->where('name', 'admin')->firstOrFail();

        User::firstOrCreate(
            ['email' => 'email@notexists.com'],
            [
                'surname' => 'admin',
                'name' => 'admin',
                'patronymic' => 'admin',
                'password' => 'QWEasd123!@#',
                'phone' => '81234123456',
                'role_id' => $adminRole->id,
            ],
        );
    }
}
