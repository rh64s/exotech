<?php

namespace App\Models;

use App\Enums\CharacteristicsType;
use Database\Factories\CharacteristicFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property string $name
 * @property string|null $unit
 * @property CharacteristicsType $data_type
 * @property-read Pivot $pivot
 */
#[Table(timestamps: false)]
#[Fillable(['name', 'unit', 'data_type'])]
class Characteristic extends Model
{
    /** @use HasFactory<CharacteristicFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data_type' => CharacteristicsType::class,
        ];
    }

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
        )->withPivot(CharacteristicsType::valueColumns());
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
