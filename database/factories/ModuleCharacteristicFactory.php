<?php

namespace Database\Factories;

use App\Models\Characteristic;
use App\Models\Module;
use App\Models\ModuleCharacteristic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModuleCharacteristic>
 */
class ModuleCharacteristicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => fake()->word(),
            'module_id' => Module::factory(),
            'characteristic_id' => Characteristic::factory(),
        ];
    }
}
