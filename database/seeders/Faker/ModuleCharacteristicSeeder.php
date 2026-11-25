<?php

namespace Database\Seeders\Faker;

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
        $characteristics = Characteristic::all();

        if ($characteristics->isEmpty()) {
            return;
        }

        foreach (Module::lazyById() as $module) {
            $count = min(fake()->numberBetween(2, 4), $characteristics->count());

            foreach ($characteristics->random($count) as $characteristic) {
                ModuleCharacteristic::factory()
                    ->forCharacteristic($characteristic)
                    ->create(['module_id' => $module->id]);
            }
        }
    }
}
