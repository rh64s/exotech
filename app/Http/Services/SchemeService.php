<?php

namespace App\Http\Services;

use App\Models\Scheme;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SchemeService
{
    public function install(Scheme $scheme, int $slotId, int $moduleId): void
    {
        DB::transaction(function () use ($scheme, $slotId, $moduleId): void {
            $scheme = Scheme::lockForUpdate()->findOrFail($scheme->id);
            $slot = $scheme->frame->slots()->find($slotId);
            $module = $slot?->compatibleModules()->find($moduleId);
            if (! $module) {
                throw ValidationException::withMessages(['module_id' => 'Аксессуар не подходит для этого крепления.']);
            }
            if ($scheme->installations()->where('frame_slot_id', $slotId)->count() >= $slot->quantity) {
                throw ValidationException::withMessages(['frame_slot_id' => 'На этом креплении нет свободных мест.']);
            }
            if ($scheme->totalWeightGrams() + $module->weight_g > $scheme->frame->max_total_weight_g) {
                throw ValidationException::withMessages(['module_id' => 'Превышена допустимая масса сборки.']);
            }
            $scheme->installations()->create(['frame_slot_id' => $slotId, 'module_id' => $moduleId]);
        });
    }
}
