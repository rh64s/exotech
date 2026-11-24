<?php

namespace Database\Factories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'need_expert_help' => fake()->boolean(),
            'is_active' => true,
            'created_at' => now(),
        ];
    }

    /**
     * Indicate that the chat needs expert help.
     */
    public function needsExpertHelp(): static
    {
        return $this->state(fn (array $attributes): array => [
            'need_expert_help' => true,
        ]);
    }

    /**
     * Indicate that the chat is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
