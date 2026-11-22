<?php

namespace Database\Seeders;

use App\Models\ModuleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $parents = ModuleCategory::factory()->count(5)->create();

        $parents->each(
            fn (ModuleCategory $parent) => ModuleCategory::factory()
                ->childOf($parent)
                ->create()
        );
    }
}
