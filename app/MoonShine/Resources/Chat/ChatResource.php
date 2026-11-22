<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Chat;

use App\Models\Chat;
use App\MoonShine\Resources\Chat\Pages\ChatDetailPage;
use App\MoonShine\Resources\Chat\Pages\ChatFormPage;
use App\MoonShine\Resources\Chat\Pages\ChatIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Chat, ChatIndexPage, ChatFormPage, ChatDetailPage>
 */
class ChatResource extends ModelResource
{
    protected string $model = Chat::class;

    protected string $title = 'Чаты';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ChatIndexPage::class,
            ChatFormPage::class,
            ChatDetailPage::class,
        ];
    }
}
