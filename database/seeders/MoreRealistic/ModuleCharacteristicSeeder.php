<?php

namespace Database\Seeders\MoreRealistic;

use App\Enums\CharacteristicsType;
use App\Models\Characteristic;
use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleCharacteristicSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $characteristics = Characteristic::all()->keyBy('name');
        $emptyValues = array_fill_keys(CharacteristicsType::valueColumns(), null);
        foreach ([
            'Рама «Смена»' => ['Масса' => 2.4, 'Материал основы' => 'Алюминиевый сплав'],
            'Рама «Шаг»' => ['Масса' => 4.1, 'Материал основы' => 'Алюминиевый сплав'],
            'Рама «Практикум»' => ['Масса' => 3.6, 'Материал основы' => 'Сталь'],
            'Плечевой подвес ПП-40' => ['Масса' => 1.2, 'Усилие компенсации' => 40],
            'Поясничный упор ПУ-60' => ['Масса' => 0.8, 'Усилие компенсации' => 60],
            'Манжета голени МГ-2' => ['Масса' => 0.22, 'Съёмная подкладка' => true],
            'Тазовый пояс ТП-1' => ['Масса' => 0.45, 'Съёмная подкладка' => false],
            'Коленный привод КП-90' => ['Масса' => 1.8, 'Номинальная мощность' => 90],
            'Инерциальный датчик ИД-100' => ['Масса' => 0.08, 'Частота измерений' => 100],
            'Датчик наклона ДН-50' => ['Масса' => 0.06, 'Частота измерений' => 50],
        ] as $moduleName => $values) {
            $module = Module::where('name', $moduleName)->firstOrFail();
            $assignments = [];
            foreach ($values as $name => $value) {
                $characteristic = $characteristics[$name];
                $assignments[$characteristic->id] = [...$emptyValues, $characteristic->data_type->valueColumn() => $value];
            }
            $module->characteristics()->syncWithoutDetaching($assignments);
        }
    }
}
