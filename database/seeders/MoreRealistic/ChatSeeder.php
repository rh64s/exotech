<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ([
            'Подбор подвеса для мастерской' => ['anna@example.test', 'elena@example.test'],
            'Запись шага в лаборатории' => ['igor@example.test', 'elena@example.test'],
        ] as $name => $participants) {
            $chat = Chat::firstOrCreate(['name' => $name], ['need_expert_help' => false, 'is_active' => true]);
            $chat->users()->syncWithoutDetaching(User::whereIn('email', $participants)->pluck('id'));
        }
    }
}
