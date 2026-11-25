<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\ModuleCategory;
use App\Models\ModuleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = ModuleCategory::pluck('id', 'name');
        foreach ([
            ['Несущая рама', 'Несущие конструкции', 'Основание для установки сменных модулей.'],
            ['Пружинный компенсатор', 'Пассивная поддержка', 'Передаёт часть нагрузки на раму без электропитания.'],
            ['Опорная манжета', 'Пассивная поддержка', 'Фиксирует модуль на теле мягкими ремнями.'],
            ['Суставной привод', 'Электроприводы', 'Помогает движению в одном суставе.'],
            ['Датчик движения', 'Измерительные модули', 'Регистрирует положение сегмента тела во времени.'],
        ] as [$name, $category, $description]) {
            ModuleType::updateOrCreate(['name' => $name], ['category_id' => $categories[$category], 'description' => $description]);
        }
    }
}
