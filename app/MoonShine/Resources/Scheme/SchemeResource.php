<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Scheme;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scheme;
use App\MoonShine\Resources\Scheme\Pages\SchemeIndexPage;
use App\MoonShine\Resources\Scheme\Pages\SchemeFormPage;
use App\MoonShine\Resources\Scheme\Pages\SchemeDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

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
