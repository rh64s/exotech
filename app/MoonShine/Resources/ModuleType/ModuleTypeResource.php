<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ModuleType;

use App\Models\ModuleType;
use App\MoonShine\Resources\ModuleType\Pages\ModuleTypeDetailPage;
use App\MoonShine\Resources\ModuleType\Pages\ModuleTypeFormPage;
use App\MoonShine\Resources\ModuleType\Pages\ModuleTypeIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<ModuleType, ModuleTypeIndexPage, ModuleTypeFormPage, ModuleTypeDetailPage>
 */
class ModuleTypeResource extends ModelResource
{
    protected string $model = ModuleType::class;

    protected string $title = 'Типы модулей';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ModuleTypeIndexPage::class,
            ModuleTypeFormPage::class,
            ModuleTypeDetailPage::class,
        ];
    }
}
