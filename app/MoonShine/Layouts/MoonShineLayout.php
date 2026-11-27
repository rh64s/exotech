<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Pages\Dashboard;
use App\MoonShine\Resources\AttachmentInterface\AttachmentInterfaceResource;
use App\MoonShine\Resources\BodyZone\BodyZoneResource;
use App\MoonShine\Resources\Characteristic\CharacteristicResource;
use App\MoonShine\Resources\Chat\ChatResource;
use App\MoonShine\Resources\Frame\FrameResource;
use App\MoonShine\Resources\FrameSlot\FrameSlotResource;
use App\MoonShine\Resources\Message\MessageResource;
use App\MoonShine\Resources\Module\ModuleResource;
use App\MoonShine\Resources\ModuleCategory\ModuleCategoryResource;
use App\MoonShine\Resources\ModuleCharacteristic\ModuleCharacteristicResource;
use App\MoonShine\Resources\ModuleType\ModuleTypeResource;
use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\Role\RoleResource;
use App\MoonShine\Resources\Scheme\SchemeResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\ColorManager\Palettes\SkyPalette;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = SkyPalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make(static fn (): string|array => __('moonshine::ui.resource.system'), [
                MenuItem::make(UserResource::class),
                MenuItem::make(RoleResource::class, 'Роли'),
            ]),
            MenuItem::make(Dashboard::class),
            MenuItem::make(ModuleTypeResource::class),
            MenuItem::make(ModuleResource::class),
            MenuItem::make(FrameResource::class),
            MenuItem::make(AttachmentInterfaceResource::class, 'Интерфейсы крепления'),
            MenuItem::make(BodyZoneResource::class, 'Зоны тела'),
            MenuItem::make(SchemeResource::class),
            MenuItem::make(CharacteristicResource::class, 'Характеристики'),
            MenuItem::make(ModuleCharacteristicResource::class, 'Характеристики модулей'),
            MenuItem::make(ChatResource::class, 'Чаты'),
            MenuItem::make(MessageResource::class, 'Сообщения'),
            MenuItem::make(OrderResource::class, 'Заказы'),
            MenuItem::make(FrameSlotResource::class, 'Крепления'),
        ];
    }

    /**
     * @param  ColorManager  $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);
    }

    /**
     * @return array<string, string>
     */
    protected function getFooterMenu(): array
    {
        return [];
    }

    protected function getFooterCopyright(): string
    {
        return \sprintf(
            <<<'HTML'
                Экзотех
                &copy; %d
                HTML,
            now()->year,
        );
    }
}
