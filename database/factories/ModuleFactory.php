<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\ModuleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 100, 100_000),
            'module_type_id' => ModuleType::factory(),
        ];
    }
}
