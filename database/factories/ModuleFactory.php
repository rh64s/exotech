<?php

namespace Database\Factories;

use App\Models\AttachmentInterface;
use App\Models\BodyZone;
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
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 1, 100000),
            'weight_g' => fake()->numberBetween(100, 3500),
            'module_type_id' => ModuleType::factory(),
            'attachment_interface_id' => AttachmentInterface::factory(),
            'body_zone_id' => null,
        ];
    }

    /**
     * Indicate the body zone the module belongs to.
     */
    public function forBodyZone(BodyZone $bodyZone): static
    {
        return $this->state(fn (array $attributes): array => [
            'body_zone_id' => $bodyZone->id,
        ]);
    }
}
