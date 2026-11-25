<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $module_id
 * @property int $max_total_weight
 * @property int $max_power_output
 */
#[Table(timestamps: false)]
#[Fillable(['module_id', 'max_total_weight', 'max_power_output'])]
class Frame extends Model
{
    /** @return BelongsTo<Module, $this> */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
