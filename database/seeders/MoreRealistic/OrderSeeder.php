<?php

namespace Database\Seeders\MoreRealistic;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Scheme;
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
        foreach ([
            ['anna@example.test', 'Поддержка в работе', OrderStatus::IN_PROGRESS],
            ['igor@example.test', 'Основа для эксперимента', OrderStatus::ON_CONSIDER],
        ] as [$email, $name, $status]) {
            $client = User::where('email', $email)->firstOrFail();
            $scheme = Scheme::where('name', $name)->firstOrFail();
            Order::firstOrCreate(['user_id' => $client->id, 'price' => $scheme->modules()->sum('price'), 'status' => $status]);
        }
    }
}
