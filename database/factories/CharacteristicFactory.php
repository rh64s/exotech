<?php

namespace Database\Factories;

use App\Enums\CharacteristicsType;
use App\Models\Characteristic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Characteristic>
 */
class CharacteristicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'unit' => fake()->optional()->randomElement(['мм', 'см', 'Вт', 'В', 'кг', 'шт']),
            'data_type' => fake()->randomElement(CharacteristicsType::values()),
        ];
    }
}
