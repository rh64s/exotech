<?php

namespace Database\Seeders\Faker;

use App\Models\Scheme;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchemeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::all();

        Scheme::factory()
            ->count(10)
            ->recycle($users)
            ->create();

        Scheme::factory()
            ->count(2)
            ->official()
            ->completed()
            ->create(['user_id' => null]);
    }
}
