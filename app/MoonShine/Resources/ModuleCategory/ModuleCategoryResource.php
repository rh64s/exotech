<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ModuleCategory;

use App\Models\ModuleCategory;
use App\MoonShine\Resources\ModuleCategory\Pages\ModuleCategoryDetailPage;
use App\MoonShine\Resources\ModuleCategory\Pages\ModuleCategoryFormPage;
use App\MoonShine\Resources\ModuleCategory\Pages\ModuleCategoryIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<ModuleCategory, ModuleCategoryIndexPage, ModuleCategoryFormPage, ModuleCategoryDetailPage>
 */
class ModuleCategoryResource extends ModelResource
{
    protected string $model = ModuleCategory::class;

    protected string $title = 'Категории модулей';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ModuleCategoryIndexPage::class,
            ModuleCategoryFormPage::class,
            ModuleCategoryDetailPage::class,
        ];
    }
}
