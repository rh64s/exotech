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

        $modules->each(function (Module $module) use ($characteristics): void {
            $count = min(fake()->numberBetween(2, 4), $characteristics->count());

            $characteristics->random($count)->each(
                fn (Characteristic $characteristic) => ModuleCharacteristic::factory()
                    ->forCharacteristic($characteristic)
                    ->create(['module_id' => $module->id])
            );
        });
    }
}
