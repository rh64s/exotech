<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['frame_id', 'body_zone_id', 'attachment_interface_id', 'quantity'])]
class FrameSlot extends Model
{
    public function frame(): BelongsTo
    {
        return $this->belongsTo(Frame::class);
    }

    public function bodyZone(): BelongsTo
    {
        return $this->belongsTo(BodyZone::class);
    }

    public function attachmentInterface(): BelongsTo
    {
        return $this->belongsTo(AttachmentInterface::class);
    }

    public function compatibleModules(): Builder
    {
        return Module::whereDoesntHave('frame')->where('body_zone_id', $this->body_zone_id)
            ->where('attachment_interface_id', $this->attachment_interface_id);
    }
}
