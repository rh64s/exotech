<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Scheme;

use App\Models\Scheme;
use App\MoonShine\Resources\Scheme\Pages\SchemeDetailPage;
use App\MoonShine\Resources\Scheme\Pages\SchemeFormPage;
use App\MoonShine\Resources\Scheme\Pages\SchemeIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Scheme, SchemeIndexPage, SchemeFormPage, SchemeDetailPage>
 */
class SchemeResource extends ModelResource
{
    protected string $model = Scheme::class;

    protected string $title = 'Сборки';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            SchemeIndexPage::class,
            SchemeFormPage::class,
            SchemeDetailPage::class,
        ];
    }
}
