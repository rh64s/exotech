<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ModuleCharacteristic;

use App\Models\ModuleCharacteristic;
use App\MoonShine\Resources\ModuleCharacteristic\Pages\ModuleCharacteristicDetailPage;
use App\MoonShine\Resources\ModuleCharacteristic\Pages\ModuleCharacteristicFormPage;
use App\MoonShine\Resources\ModuleCharacteristic\Pages\ModuleCharacteristicIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<ModuleCharacteristic, ModuleCharacteristicIndexPage, ModuleCharacteristicFormPage, ModuleCharacteristicDetailPage>
 */
class ModuleCharacteristicResource extends ModelResource
{
    protected string $model = ModuleCharacteristic::class;

    protected string $title = 'Характеристики модулей';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ModuleCharacteristicIndexPage::class,
            ModuleCharacteristicFormPage::class,
            ModuleCharacteristicDetailPage::class,
        ];
    }
}
