<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\Chat;
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
        foreach ([
            'Карманы для мастерской' => [
                'anna@example.test' => 'Можно закрепить два одинаковых кармана для инструмента?',
                'elena@example.test' => 'Да, на спине у «Смены» два места. Посмотрите сборку «Поддержка в работе».',
            ],
            'Крепление фонаря' => [
                'igor@example.test' => 'Куда крепится наручный фонарь?',
                'elena@example.test' => 'Выберите текстильную петлю на правой руке.',
            ],
        ] as $name => $messages) {
            $chat = Chat::where('name', $name)->firstOrFail();
            foreach ($messages as $email => $content) {
                $chat->messages()->firstOrCreate(['user_id' => $chat->users()->where('email', $email)->firstOrFail()->id, 'content' => $content]);
            }
        }
    }
}
