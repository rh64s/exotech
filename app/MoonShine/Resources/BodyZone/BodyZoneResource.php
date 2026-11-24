<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\BodyZone;

use App\Models\BodyZone;
use App\MoonShine\Resources\BodyZone\Pages\BodyZoneDetailPage;
use App\MoonShine\Resources\BodyZone\Pages\BodyZoneFormPage;
use App\MoonShine\Resources\BodyZone\Pages\BodyZoneIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<BodyZone, BodyZoneIndexPage, BodyZoneFormPage, BodyZoneDetailPage>
 */
class BodyZoneResource extends ModelResource
{
    protected string $model = BodyZone::class;

    protected string $title = 'Зоны тела';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            BodyZoneIndexPage::class,
            BodyZoneFormPage::class,
            BodyZoneDetailPage::class,
        ];
    }
}
