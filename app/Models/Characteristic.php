<?php

namespace App\Models;

use Database\Factories\CharacteristicFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $unit
 * @property string $data_type
 */
#[Table(timestamps: false)]
#[Fillable(['name', 'unit', 'data_type'])]
class Characteristic extends Model
{
    /** @use HasFactory<CharacteristicFactory> */
    use HasFactory;

    /**
     * Get the modules that have the characteristic.
     *
     * @return BelongsToMany<Module, $this>
     */
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(
            Module::class,
            'module_characteristics',
            'characteristic_id',
            'module_id',
        )->withPivot('value');
    }

    /**
     * Get the module characteristic records.
     *
     * @return HasMany<ModuleCharacteristic, $this>
     */
    public function moduleCharacteristics(): HasMany
    {
        return $this->hasMany(ModuleCharacteristic::class);
    }
}
