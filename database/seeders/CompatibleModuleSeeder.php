<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompatibleModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $modules = Module::all();

        if ($modules->count() < 2) {
            return;
        }

        $modules->each(function (Module $module) use ($modules): void {
            $modules
                ->where('id', '!=', $module->id)
                ->shuffle()
                ->take(2)
                ->each(function (Module $compatibleModule) use ($module): void {
                    $module->addCompatibleModule($compatibleModule);
                    $compatibleModule->addCompatibleModule($module);
                });
        });
    }
}
