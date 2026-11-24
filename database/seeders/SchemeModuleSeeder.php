<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Scheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchemeModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $modules = Module::all();

        if ($modules->count() < 3) {
            return;
        }

        Scheme::all()->each(function (Scheme $scheme) use ($modules): void {
            $scheme->modules()->detach();

            $selected = $modules->shuffle()->take(3);
            $rootModule = $selected->shift();

            if (! $rootModule instanceof Module) {
                return;
            }

            $scheme->modules()->attach($rootModule->id);

            $rootSchemeModuleId = DB::table('scheme_modules')
                ->where('scheme_id', $scheme->id)
                ->where('module_id', $rootModule->id)
                ->value('id');

            $selected->each(
                fn (Module $module) => $scheme->modules()->attach(
                    $module->id,
                    ['parent_scheme_modules_id' => $rootSchemeModuleId],
                )
            );
        });
    }
}
