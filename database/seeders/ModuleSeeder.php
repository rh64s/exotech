<?php

namespace Database\Seeders;

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
        $moduleTypes = ModuleType::all();

        Module::factory()
            ->count(10)
            ->recycle($moduleTypes)
            ->create();
    }
}
