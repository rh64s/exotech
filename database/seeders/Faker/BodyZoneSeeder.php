<?php

namespace Database\Seeders\Faker;

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
        BodyZone::create(['name' => 'Каркас']); // id 1
        BodyZone::create(['name' => 'Ноги', 'parent_id' => 1]); // id 2
        BodyZone::create(['name' => 'Рука', 'parent_id' => 1]); // id 3
        BodyZone::create(['name' => 'Шея', 'parent_id' => 1]); // id 4
    }
}
