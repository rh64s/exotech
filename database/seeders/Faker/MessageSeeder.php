<?php

namespace Database\Seeders\Faker;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $chats = Chat::query()->with('users')->get();
        $users = User::all();

        if ($chats->isEmpty()) {
            return;
        }

        $chats->each(function (Chat $chat) use ($users): void {
            $participants = $chat->users->isNotEmpty() ? $chat->users : $users;

            Message::factory()
                ->count(3)
                ->state(fn (): array => [
                    'user_id' => $participants->isNotEmpty() ? $participants->random()->id : null,
                ])
                ->create(['chat_id' => $chat->id]);
        });
    }
}
