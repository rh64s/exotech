<?php

namespace App\Models;

use Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $content
 * @property int|null $user_id
 * @property int $chat_id
 */
#[Fillable(['content', 'user_id', 'chat_id'])]
class Message extends Model
{
    /** @use HasFactory<MessageFactory> */
    use HasFactory;

    /**
     * Get the user that posted the message.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the chat the message belongs to.
     *
     * @return BelongsTo<Chat, $this>
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
