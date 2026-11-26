<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\BodyZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BodyZoneSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $frame = BodyZone::firstOrCreate(['name' => 'Каркас', 'parent_id' => null]);

        foreach (['Спина', 'Правая рука', 'Левая рука', 'Правая нога', 'Левая нога'] as $name) {
            $frame->children()->firstOrCreate(['name' => $name]);
        }
    }
}
