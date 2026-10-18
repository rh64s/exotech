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
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'official' => false,
            'completed' => false,
        ];
    }

    /**
     * Indicate that the scheme is an official one.
     */
    public function official(): static
    {
        return $this->state(fn (array $attributes) => [
            'official' => true,
        ]);
    }

    /**
     * Indicate that the scheme has been completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'completed' => true,
        ]);
    }
}
