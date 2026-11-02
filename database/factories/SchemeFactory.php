<?php

namespace Database\Factories;

use App\Models\Scheme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Scheme>
 */
class SchemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'official' => false,
            'completed' => false,
        ];
    }

    /**
     * Indicate that the scheme is official.
     */
    public function official(): static
    {
        return $this->state(fn (array $attributes) => [
            'official' => true,
        ]);
    }

    /**
     * Indicate that the scheme is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed' => true,
        ]);
    }
}
