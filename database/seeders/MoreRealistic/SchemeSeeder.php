<?php

namespace Database\Seeders\MoreRealistic;

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
        foreach ([
            ['Поддержка в работе', 'Пассивная разгрузка плеч и поясницы для сборочного участка.', null],
            ['Поддержка движения', 'Тазовая рама с коленным приводом и опорой голени.', null],
            ['Основа для эксперимента', 'Сравнение наклона корпуса и движения голени во время ходьбы.', 'igor@example.test'],
        ] as [$name, $description, $owner]) {
            Scheme::updateOrCreate([
                'name' => $name, 'user_id' => $owner === null ? null : User::where('email', $owner)->firstOrFail()->id,
            ], ['description' => $description, 'official' => $owner === null, 'completed' => $owner === null]);
        }
    }
}
