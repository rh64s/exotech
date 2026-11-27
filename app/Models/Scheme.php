<?php

namespace App\Models;

use Database\Factories\SchemeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int $frame_id
 * @property string $name
 * @property string $description
 * @property bool $official
 * @property bool $completed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['user_id', 'frame_id', 'name', 'description', 'official', 'completed'])]
class Scheme extends Model
{
    /** @use HasFactory<SchemeFactory> */
    use HasFactory;

    public function frame(): BelongsTo
    {
        return $this->belongsTo(Frame::class);
    }

    public function installations(): HasMany
    {
        return $this->hasMany(SchemeModule::class);
    }

    public function totalWeightGrams(): int
    {
        return $this->frame->module->weight_g + (int) $this->modules()->sum('modules.weight_g');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'official' => 'boolean',
            'completed' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the scheme.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the modules included in the scheme.
     *
     * @return BelongsToMany<Module, $this>
     */
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(
            Module::class,
            'scheme_modules',
            'scheme_id',
            'module_id',
        )->withPivot('id', 'frame_slot_id');
    }
}
