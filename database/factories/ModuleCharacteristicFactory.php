<?php

namespace Database\Factories;

use App\Enums\CharacteristicsType;
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

    /**
     * Indicate the characteristic and generate a value that matches its data type.
     */
    public function forCharacteristic(Characteristic $characteristic): static
    {
        return $this->state(fn (): array => [
            'characteristic_id' => $characteristic->id,
            'value' => $this->valueForType($characteristic->data_type),
        ]);
    }

    /**
     * Generate a value that is valid for the given characteristic data type.
     */
    private function valueForType(CharacteristicsType $type): string
    {
        return match ($type) {
            CharacteristicsType::String => fake()->word(),
            CharacteristicsType::Integer => (string) fake()->numberBetween(1, 1000),
            CharacteristicsType::Float => (string) fake()->randomFloat(2, 0.1, 1000),
            CharacteristicsType::Boolean => fake()->boolean() ? 'true' : 'false',
        };
    }
}
