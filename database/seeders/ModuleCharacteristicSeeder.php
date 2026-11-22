<?php

namespace Database\Seeders;

use App\Models\Characteristic;
use App\Models\Module;
use App\Models\ModuleCharacteristic;
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
        $modules = Module::all();
        $characteristics = Characteristic::all();

        if ($modules->isEmpty() || $characteristics->isEmpty()) {
            return;
        }

        ModuleCharacteristic::factory()
            ->count(10)
            ->recycle([$modules, $characteristics])
            ->create();
    }
}
