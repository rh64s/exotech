<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\AttachmentInterface;

use App\Models\AttachmentInterface;
use App\MoonShine\Resources\AttachmentInterface\Pages\AttachmentInterfaceDetailPage;
use App\MoonShine\Resources\AttachmentInterface\Pages\AttachmentInterfaceFormPage;
use App\MoonShine\Resources\AttachmentInterface\Pages\AttachmentInterfaceIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<AttachmentInterface, AttachmentInterfaceIndexPage, AttachmentInterfaceFormPage, AttachmentInterfaceDetailPage>
 */
class AttachmentInterfaceResource extends ModelResource
{
    protected string $model = AttachmentInterface::class;

    protected string $title = 'Интерфейсы крепления';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            AttachmentInterfaceIndexPage::class,
            AttachmentInterfaceFormPage::class,
            AttachmentInterfaceDetailPage::class,
        ];
    }
}
