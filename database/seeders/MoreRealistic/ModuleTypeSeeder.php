<?php

namespace Database\Seeders\MoreRealistic;

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
        foreach ([
            'Несущая рама' => 'Основание для установки сменных модулей.',
            'Навесное оборудование' => 'Крепится непосредственно к заводскому каркасу.',
        ] as $name => $description) {
            ModuleType::updateOrCreate(['name' => $name], ['description' => $description]);
        }
    }
}
