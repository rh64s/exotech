<?php

namespace App\Models;

use Database\Factories\ModuleTypeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
#[Table(timestamps: false)]
#[Fillable(['name'])]
class ModuleType extends Model
{
    /** @use HasFactory<ModuleTypeFactory> */
    use HasFactory;

    /**
     * Get the modules that belong to the type.
     *
     * @return HasMany<Module, $this>
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
