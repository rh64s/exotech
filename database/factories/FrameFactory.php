<?php

namespace Database\Factories;

use App\Models\Frame;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Frame>
 */
class FrameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id' => Module::factory()->state(['attachment_interface_id' => null, 'body_zone_id' => null]),
            'max_total_weight_g' => 15000,
        ];
    }
}
