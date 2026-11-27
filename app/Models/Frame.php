<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $module_id
 * @property int $max_total_weight_g
 * @property int|null $max_power_output
 */
#[Table(timestamps: false)]
#[Fillable(['module_id', 'max_total_weight_g', 'max_power_output'])]
class Frame extends Model
{
    use HasFactory;

    public function slots(): HasMany
    {
        return $this->hasMany(FrameSlot::class);
    }

    /** @return BelongsTo<Module, $this> */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
