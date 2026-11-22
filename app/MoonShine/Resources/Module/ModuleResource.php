<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Module;

use App\Models\Module;
use App\MoonShine\Resources\Module\Pages\ModuleDetailPage;
use App\MoonShine\Resources\Module\Pages\ModuleFormPage;
use App\MoonShine\Resources\Module\Pages\ModuleIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Module, ModuleIndexPage, ModuleFormPage, ModuleDetailPage>
 */
class ModuleResource extends ModelResource
{
    protected string $model = Module::class;

    protected string $title = 'Модули';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ModuleIndexPage::class,
            ModuleFormPage::class,
            ModuleDetailPage::class,
        ];
    }
}
