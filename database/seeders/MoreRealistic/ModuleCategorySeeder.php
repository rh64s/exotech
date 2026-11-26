<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\ModuleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['Несущие конструкции', 'Аксессуары'] as $name) {
            ModuleCategory::firstOrCreate(['name' => $name]);
        }
    }
}
