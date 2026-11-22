<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Role;

use App\Models\Role;
use App\MoonShine\Resources\Role\Pages\RoleDetailPage;
use App\MoonShine\Resources\Role\Pages\RoleFormPage;
use App\MoonShine\Resources\Role\Pages\RoleIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Role, RoleIndexPage, RoleFormPage, RoleDetailPage>
 */
class RoleResource extends ModelResource
{
    protected string $model = Role::class;

    protected string $title = 'Роли';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            RoleIndexPage::class,
            RoleFormPage::class,
            RoleDetailPage::class,
        ];
    }
}
