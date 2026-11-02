<?php

namespace App\Models;

use Database\Factories\ChatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property bool $need_expert_help
 * @property string $name
 * @property Carbon $created_at
 */
#[Fillable(['name', 'need_expert_help'])]
class Chat extends Model
{
    /** @use HasFactory<ChatFactory> */
    use HasFactory;

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    public const UPDATED_AT = null;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'need_expert_help' => 'boolean',
        ];
    }

    /**
     * Get the users that participate in the chat.
     *
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'related_users_to_chat',
            'chat_id',
            'user_id',
        );
    }

    /**
     * Get the messages posted in the chat.
     *
     * @return HasMany<Message, $this>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
