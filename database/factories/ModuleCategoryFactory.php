<?php

namespace Database\Factories;

use App\Models\ModuleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ModuleCategory>
 */
class ModuleCategoryFactory extends Factory
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
     * Indicate that the category belongs to the given parent.
     */
    public function childOf(ModuleCategory $parent): static
    {
        return $this->state(fn (array $attributes): array => [
            'parent_id' => $parent->id,
        ]);
    }
}
