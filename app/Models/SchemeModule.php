<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['module_id', 'frame_slot_id'])]
class SchemeModule extends Model
{
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
