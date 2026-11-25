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
            'Подбор подвеса для мастерской' => [
                'anna@example.test' => 'Для работы над верстаком нужен подвес без аккумулятора. Подойдёт ПП-40?',
                'elena@example.test' => 'Да, он крепится к раме «Смена». Посмотрите сборку «Поддержка в работе».',
            ],
            'Запись шага в лаборатории' => [
                'igor@example.test' => 'Хочу записывать движение голени сто раз в секунду. Какой датчик выбрать?',
                'elena@example.test' => 'ИД-100 пишет с частотой 100 Гц. В вашей схеме он подключён к раме «Практикум».',
            ],
        ] as $name => $messages) {
            $chat = Chat::where('name', $name)->firstOrFail();
            foreach ($messages as $email => $content) {
                $chat->messages()->firstOrCreate(['user_id' => $chat->users()->where('email', $email)->firstOrFail()->id, 'content' => $content]);
            }
        }
    }
}
