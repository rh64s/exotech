<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Frame;

use App\Models\Frame;
use App\MoonShine\Resources\Frame\Pages\FrameDetailPage;
use App\MoonShine\Resources\Frame\Pages\FrameFormPage;
use App\MoonShine\Resources\Frame\Pages\FrameIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Frame, FrameIndexPage, FrameFormPage, FrameDetailPage>
 */
class FrameResource extends ModelResource
{
    protected string $model = Frame::class;

    protected string $title = 'Каркасы';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            FrameIndexPage::class,
            FrameFormPage::class,
            FrameDetailPage::class,
        ];
    }
}
