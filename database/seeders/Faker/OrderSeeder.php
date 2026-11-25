<?php

namespace Database\Seeders\Faker;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::all();

        Order::factory()
            ->count(10)
            ->recycle($users)
            ->create();
    }
}
