<?php

namespace App\Models;

use Database\Factories\ModuleTypeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $category_id
 */
#[Table(timestamps: false)]
#[Fillable(['name', 'description', 'category_id'])]
class ModuleType extends Model
{
    /** @use HasFactory<ModuleTypeFactory> */
    use HasFactory;

    /**
     * Get the category the module type belongs to.
     *
     * @return BelongsTo<ModuleCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ModuleCategory::class, 'category_id');
    }

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
