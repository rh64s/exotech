<?php

namespace Database\Seeders;

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
        User::createOrFirst([
            'name' => 'admin',
            'surname' => 'admin',
            'patronymic' => 'admin',
            'email' => 'email@notexists.com',
            'password' => 'QWEasd123!@#',
            'phone' => '81234123456',
            'role_id' => Role::firstWhere(['name' => 'admin'])->id,
        ]);
    }
}
