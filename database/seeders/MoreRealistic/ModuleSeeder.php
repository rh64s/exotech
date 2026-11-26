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
        $loop = 'Текстильная петля 40 мм';

        foreach ([
            ['Рама «Смена»', 'Несущая рама', null, null, 51100, 6400, 'Грузовой экзоскелет с заводскими опорами рук, ног и поясницы.'],
            ['Рама «Шаг»', 'Несущая рама', null, null, 107900, 6120, 'Каркас со встроенными коленными приводами и манжетами.'],
            ['Карман для инструмента', 'Навесное оборудование', 'Спина', $rail, 2400, 450, 'Съёмный карман на одно крепление.'],
            ['Контейнер', 'Навесное оборудование', 'Спина', $rail, 4800, 1700, 'Закрытый контейнер для переноски инструмента.'],
            ['Наручный фонарь', 'Навесное оборудование', 'Правая рука', $loop, 1900, 180, 'Фонарь с автономным питанием.'],
        ] as [$name, $type, $zone, $interface, $price, $weight, $description]) {
            $module = Module::updateOrCreate(['name' => $name], [
                'description' => $description, 'price' => $price,
                'weight_g' => $weight, 'module_type_id' => $types[$type], 'body_zone_id' => $zone ? $zones[$zone] : null,
                'attachment_interface_id' => $interface ? $interfaces[$interface] : null,
            ]);
            if ($type === 'Несущая рама') {
                $frame = $module->frame()->updateOrCreate([], ['max_total_weight_g' => 12000, 'max_power_output' => $name === 'Рама «Шаг»' ? 180 : null]);
                foreach ([['Спина', $rail, $name === 'Рама «Смена»' ? 2 : 1], ['Правая рука', $loop, 1]] as [$zone, $interface, $quantity]) {
                    $frame->slots()->updateOrCreate(['body_zone_id' => $zones[$zone], 'attachment_interface_id' => $interfaces[$interface]], ['quantity' => $quantity]);
                }
            }
        }
    }
}
