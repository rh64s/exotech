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
            ['Навесное оборудование', 'Аксессуары', 'Крепится непосредственно к заводскому каркасу.'],
        ] as [$name, $category, $description]) {
            ModuleType::updateOrCreate(['name' => $name], ['category_id' => $categories[$category], 'description' => $description]);
        }
    }
}
