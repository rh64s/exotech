<?php

namespace App\Models;

use App\Enums\AttachmentInterfaceType;
use Database\Factories\AttachmentInterfaceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property AttachmentInterfaceType $type
 */
#[Table(timestamps: false)]
#[Fillable(['name', 'type'])]
class AttachmentInterface extends Model
{
    /** @use HasFactory<AttachmentInterfaceFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => AttachmentInterfaceType::class,
        ];
    }

    /**
     * Get the modules that use the attachment interface.
     *
     * @return HasMany<Module, $this>
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
