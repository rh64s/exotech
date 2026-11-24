<?php

namespace App\Models;

use Database\Factories\BodyZoneFactory;
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
class BodyZone extends Model
{
    /** @use HasFactory<BodyZoneFactory> */
    use HasFactory;

    /**
     * Get the parent body zone.
     *
     * @return BelongsTo<BodyZone, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the child body zones.
     *
     * @return HasMany<BodyZone, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the modules assigned to the body zone.
     *
     * @return HasMany<Module, $this>
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
