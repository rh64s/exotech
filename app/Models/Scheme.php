<?php

namespace App\Models;

use Database\Factories\SchemeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $description
 * @property bool $official
 * @property bool $completed
 */
#[Fillable(['user_id', 'name', 'description', 'official', 'completed'])]
class Scheme extends Model
{
    /** @use HasFactory<SchemeFactory> */
    use HasFactory;

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
        );
    }
}
