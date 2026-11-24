<?php

namespace Database\Factories;

use App\Enums\AttachmentInterfaceType;
use App\Models\AttachmentInterface;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttachmentInterface>
 */
class AttachmentInterfaceFactory extends Factory
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
            'type' => fake()->randomElement(AttachmentInterfaceType::values()),
        ];
    }

    /**
     * Indicate the attachment interface type.
     */
    public function ofType(AttachmentInterfaceType $type): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => $type,
        ]);
    }
}
