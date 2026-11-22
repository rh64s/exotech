<?php

namespace App\Models;

use Database\Factories\ModuleCharacteristicFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $value
 * @property int $module_id
 * @property int $characteristic_id
 */
#[Table(timestamps: false)]
#[Fillable(['value', 'module_id', 'characteristic_id'])]
class ModuleCharacteristic extends Model
{
    /** @use HasFactory<ModuleCharacteristicFactory> */
    use HasFactory;

    /**
     * Get the module the characteristic value belongs to.
     *
     * @return BelongsTo<Module, $this>
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the characteristic of the value.
     *
     * @return BelongsTo<Characteristic, $this>
     */
    public function characteristic(): BelongsTo
    {
        return $this->belongsTo(Characteristic::class);
    }
}
