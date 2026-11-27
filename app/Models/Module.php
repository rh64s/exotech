<?php

namespace App\Models;

use App\Enums\CharacteristicsType;
use Database\Factories\ModuleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $price
 * @property int $module_type_id
 * @property int $weight_g
 * @property int|null $attachment_interface_id
 * @property int|null $body_zone_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    "name",
    "description",
    "price",
    "weight_g",
    "module_type_id",
    "attachment_interface_id",
    "body_zone_id",
])]
class Module extends Model
{
    /** @use HasFactory<ModuleFactory> */
    use HasFactory;

    /** @return HasOne<Frame, $this> */
    public function frame(): HasOne
    {
        return $this->hasOne(Frame::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "price" => "decimal:2",
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
     * Get the attachment interface of the module.
     *
     * @return BelongsTo<AttachmentInterface, $this>
     */
    public function attachmentInterface(): BelongsTo
    {
        return $this->belongsTo(AttachmentInterface::class);
    }

    /**
     * Get the body zone the module belongs to.
     *
     * @return BelongsTo<BodyZone, $this>
     */
    public function bodyZone(): BelongsTo
    {
        return $this->belongsTo(BodyZone::class);
    }

    /**
     * Get the characteristics of the module.
     *
     * @return BelongsToMany<Characteristic, $this>
     */
    public function characteristics(): BelongsToMany
    {
        return $this->belongsToMany(
            Characteristic::class,
            "module_characteristics",
            "module_id",
            "characteristic_id",
        )->withPivot(CharacteristicsType::valueColumns());
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
            "scheme_modules",
            "module_id",
            "scheme_id",
        )->withPivot("id", "frame_slot_id");
    }

    public function wishlistedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "wishlist");
    }
}
