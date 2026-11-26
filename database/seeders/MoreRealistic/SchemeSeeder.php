<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\Module;
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
            ['Поддержка в работе', 'Грузовой каркас с двумя карманами для инструмента.', null],
            ['Мой грузовой каркас', 'Черновик без аксессуаров.', 'igor@example.test'],
        ] as [$name, $description, $owner]) {
            Scheme::updateOrCreate([
                'name' => $name, 'user_id' => $owner === null ? null : User::where('email', $owner)->firstOrFail()->id,
            ], ['frame_id' => Module::where('name', 'Рама «Смена»')->sole()->frame->id,
                'description' => $description, 'official' => $owner === null, 'completed' => $owner === null]);
        }
    }
}
