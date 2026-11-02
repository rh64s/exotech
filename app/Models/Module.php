<?php

namespace App\Models;

use Database\Factories\ModuleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property int $module_type_id
 */
#[Fillable(['name', 'description', 'price', 'module_type_id'])]
class Module extends Model
{
    /** @use HasFactory<ModuleFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the type the module belongs to.
     *
     * @return BelongsTo<ModuleType, $this>
     */
    public function moduleType(): BelongsTo
    {
        return $this->belongsTo(ModuleType::class);
    }

    /**
     * Get the modules that are compatible with the module.
     *
     * @return BelongsToMany<Module, $this>
     */
    public function compatibleModules(): BelongsToMany
    {
        return $this->belongsToMany(
            Module::class,
            'compatible_modules',
            'module_id',
            'compatible_module_id',
        );
    }

    public function addCompatibleModule(Module $module): void
    {
        if ($this->id !== $module->id) {
            $this->compatibleModules()->attach($module->id);
        } else {

        }
    }

    /**
     * Get the schemes that include the module.
     *
     * @return BelongsToMany<Scheme, $this>
     */
    public function schemes(): BelongsToMany
    {
        return $this->belongsToMany(
            Scheme::class,
            'scheme_modules',
            'module_id',
            'scheme_id',
        );
    }
}
