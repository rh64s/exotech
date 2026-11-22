<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Characteristic;

use App\Models\Characteristic;
use App\MoonShine\Resources\Characteristic\Pages\CharacteristicDetailPage;
use App\MoonShine\Resources\Characteristic\Pages\CharacteristicFormPage;
use App\MoonShine\Resources\Characteristic\Pages\CharacteristicIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Characteristic, CharacteristicIndexPage, CharacteristicFormPage, CharacteristicDetailPage>
 */
class CharacteristicResource extends ModelResource
{
    protected string $model = Characteristic::class;

    protected string $title = 'Характеристики';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CharacteristicIndexPage::class,
            CharacteristicFormPage::class,
            CharacteristicDetailPage::class,
        ];
    }
}
