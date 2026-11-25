<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\AttachmentInterface;
use App\Models\BodyZone;
use App\Models\Module;
use App\Models\ModuleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $types = ModuleType::pluck('id', 'name');
        $interfaces = AttachmentInterface::pluck('id', 'name');
        $zones = BodyZone::pluck('id', 'name');
        $rail = 'Монтажная рейка М6';
        $socket = 'Разъём питания и данных 24 В';
        $loop = 'Текстильная петля 40 мм';

        foreach ([
            ['Рама «Смена»', 'Несущая рама', 'Каркас', $rail, 26400, 'Лёгкая спинная рама с поясным упором для работы стоя.'],
            ['Рама «Шаг»', 'Несущая рама', 'Каркас', $rail, 45800, 'Тазовая рама со встроенным питанием 24 В для приводов нижних конечностей.'],
            ['Рама «Практикум»', 'Несущая рама', 'Каркас', $rail, 39200, 'Лабораторная рама с питанием 24 В и портом для записи показаний датчиков.'],
            ['Плечевой подвес ПП-40', 'Пружинный компенсатор', 'Плечевой пояс', $rail, 13500, 'Пара пружинных рычагов для поддержки поднятых рук.'],
            ['Поясничный упор ПУ-60', 'Пружинный компенсатор', 'Спина', $rail, 11200, 'Упругая вставка поддерживает поясницу при наклоне.'],
            ['Манжета голени МГ-2', 'Опорная манжета', 'Голень', $loop, 3200, 'Широкая манжета для фиксации нижнего рычага коленного привода.'],
            ['Тазовый пояс ТП-1', 'Опорная манжета', 'Таз', $loop, 4800, 'Распределяет давление нижней опоры рамы по поясу.'],
            ['Коленный привод КП-90', 'Суставной привод', 'Колено', $socket, 58900, 'Съёмный привод с нижним рычагом и петлями для манжеты.'],
            ['Инерциальный датчик ИД-100', 'Датчик движения', 'Голень', $socket, 8100, 'Регистрирует ускорение и поворот голени при ходьбе.'],
            ['Датчик наклона ДН-50', 'Датчик движения', 'Спина', $socket, 6400, 'Записывает угол наклона туловища во время рабочего цикла.'],
        ] as [$name, $type, $zone, $interface, $price, $description]) {
            $module = Module::updateOrCreate(['name' => $name], [
                'description' => $description, 'price' => $price,
                'module_type_id' => $types[$type], 'body_zone_id' => $zones[$zone],
                'attachment_interface_id' => $interfaces[$interface],
            ]);
            if ($type === 'Несущая рама') {
                $module->frames()->updateOrCreate([], ['max_total_weight' => 12, 'max_power_output' => match ($name) {
                    'Рама «Шаг»' => 180, 'Рама «Практикум»' => 120, default => 0,
                }]);
            }
        }
    }
}
