<?php

namespace Database\Seeders\MoreRealistic;

use App\Enums\CharacteristicsType;
use App\Models\Characteristic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacteristicSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (
            [
                ['Материал основы', null, CharacteristicsType::String],
                ['Съёмная подкладка', null, CharacteristicsType::Boolean],
                ['Номинальная мощность', 'Вт', CharacteristicsType::Integer],
                ['Частота измерений', 'Гц', CharacteristicsType::Integer],
                ['Усилие компенсации', 'Н', CharacteristicsType::Integer],
            ] as [$name, $unit, $type]
        ) {
            Characteristic::updateOrCreate(
                ['name' => $name],
                ['unit' => $unit, 'data_type' => $type],
            );
        }
    }
}
