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
            'Рама «Смена»' => ['Материал основы' => 'Алюминиевый сплав'],
            'Рама «Шаг»' => ['Материал основы' => 'Алюминиевый сплав'],
            'Карман для инструмента' => ['Съёмная подкладка' => false],
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
