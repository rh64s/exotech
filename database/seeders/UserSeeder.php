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
        $roles = Role::where(['name' => 'client'])->orWhere(['name' => 'expert'])->get();

        User::factory()
            ->count(9)
            ->create([
                'role_id' => $roles->random()->id,
            ]);
    }
}
