<?php

namespace Database\Seeders;

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
        $parents = BodyZone::factory()->count(5)->create();

        $parents->each(
            fn (BodyZone $parent) => BodyZone::factory()
                ->count(2)
                ->childOf($parent)
                ->create()
        );
    }
}
