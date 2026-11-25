<?php

namespace Database\Seeders\Faker;

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
        $chats = Chat::factory()->count(10)->create();
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $chats->each(function (Chat $chat) use ($users): void {
            $count = min(fake()->numberBetween(2, 4), $users->count());

            $chat->users()->syncWithoutDetaching(
                $users->random($count)->pluck('id')->all(),
            );
        });
    }
}
