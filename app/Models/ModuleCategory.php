<?php

namespace App\Models;

use Database\Factories\ModuleCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 */
#[Table(timestamps: false)]
#[Fillable(['name', 'parent_id'])]
class ModuleCategory extends Model
{
    /** @use HasFactory<ModuleCategoryFactory> */
    use HasFactory;

    /**
     * Get the parent category.
     *
     * @return BelongsTo<ModuleCategory, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ModuleCategory::class, 'parent_id');
    }

    /**
     * Get the child categories.
     *
     * @return HasMany<ModuleCategory, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(ModuleCategory::class, 'parent_id');
    }

    /**
     * Get the module types that belong to the category.
     *
     * @return HasMany<ModuleType, $this>
     */
    public function moduleTypes(): HasMany
    {
        return $this->hasMany(ModuleType::class, 'category_id');
    }
}
