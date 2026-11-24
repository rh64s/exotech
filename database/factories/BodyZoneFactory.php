<?php

namespace Database\Factories;

use App\Models\BodyZone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BodyZone>
 */
class BodyZoneFactory extends Factory
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
            'parent_id' => null,
        ];
    }

    /**
     * Indicate that the body zone belongs to the given parent.
     */
    public function childOf(BodyZone $parent): static
    {
        return $this->state(fn (array $attributes): array => [
            'parent_id' => $parent->id,
        ]);
    }
}
