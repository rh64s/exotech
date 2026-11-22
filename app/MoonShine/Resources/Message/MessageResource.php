<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Message;

use App\Models\Message;
use App\MoonShine\Resources\Message\Pages\MessageDetailPage;
use App\MoonShine\Resources\Message\Pages\MessageFormPage;
use App\MoonShine\Resources\Message\Pages\MessageIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Message, MessageIndexPage, MessageFormPage, MessageDetailPage>
 */
class MessageResource extends ModelResource
{
    protected string $model = Message::class;

    protected string $title = 'Сообщения';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            MessageIndexPage::class,
            MessageFormPage::class,
            MessageDetailPage::class,
        ];
    }
}
