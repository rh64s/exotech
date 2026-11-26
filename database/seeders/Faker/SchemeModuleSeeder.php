<?php

namespace Database\Seeders\Faker;

use App\Http\Services\SchemeService;
use App\Models\Module;
use App\Models\Scheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchemeModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(SchemeService $assembly): void
    {
        foreach (Scheme::with('frame')->get() as $scheme) {
            $module = Module::whereDoesntHave('frame')->whereNotNull('body_zone_id')->whereNotNull('attachment_interface_id')
                ->where('weight_g', '<=', $scheme->frame->max_total_weight_g - $scheme->totalWeightGrams())->inRandomOrder()->first();
            if ($module) {
                $slot = $scheme->frame->slots()->firstOrCreate($module->only('body_zone_id', 'attachment_interface_id'), ['quantity' => 1]);
                if ($scheme->installations()->where('frame_slot_id', $slot->id)->count() < $slot->quantity) {
                    $assembly->install($scheme, $slot->id, $module->id);
                }
            }
        }
    }
}
