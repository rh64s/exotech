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
        $type = fake()->randomElement(CharacteristicsType::cases());

        return [
            ...$this->valuesForType($type),
            'module_id' => Module::factory(),
            'characteristic_id' => Characteristic::factory()->state(['data_type' => $type]),
        ];
    }

    /**
     * Indicate the characteristic and generate a value that matches its data type.
     */
    public function forCharacteristic(Characteristic $characteristic): static
    {
        return $this->state(fn (): array => [
            'characteristic_id' => $characteristic->id,
            ...$this->valuesForType($characteristic->data_type),
        ]);
    }

    /**
     * @return array<string, string|int|float|bool|null>
     */
    private function valuesForType(CharacteristicsType $type): array
    {
        $values = array_fill_keys(CharacteristicsType::valueColumns(), null);
        $values[$type->valueColumn()] = match ($type) {
            CharacteristicsType::String => fake()->word(),
            CharacteristicsType::Integer => fake()->numberBetween(1, 1000),
            CharacteristicsType::Float => fake()->randomFloat(2, 0.1, 1000),
            CharacteristicsType::Boolean => fake()->boolean(),
        };

        return $values;
    }
}
