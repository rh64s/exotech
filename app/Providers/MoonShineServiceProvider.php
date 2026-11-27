<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\AttachmentInterface\AttachmentInterfaceResource;
use App\MoonShine\Resources\BodyZone\BodyZoneResource;
use App\MoonShine\Resources\Characteristic\CharacteristicResource;
use App\MoonShine\Resources\Chat\ChatResource;
use App\MoonShine\Resources\Frame\FrameResource;
use App\MoonShine\Resources\FrameSlot\FrameSlotResource;
use App\MoonShine\Resources\Message\MessageResource;
use App\MoonShine\Resources\Module\ModuleResource;
use App\MoonShine\Resources\ModuleCharacteristic\ModuleCharacteristicResource;
use App\MoonShine\Resources\ModuleType\ModuleTypeResource;
use App\MoonShine\Resources\Order\OrderResource;
use App\MoonShine\Resources\Role\RoleResource;
use App\MoonShine\Resources\Scheme\SchemeResource;
use App\MoonShine\Resources\User\UserResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                UserResource::class,
                AttachmentInterfaceResource::class,
                BodyZoneResource::class,
                ModuleTypeResource::class,
                ModuleResource::class,
                FrameResource::class,
                SchemeResource::class,
                CharacteristicResource::class,
                ModuleCharacteristicResource::class,
                ChatResource::class,
                MessageResource::class,
                OrderResource::class,
                RoleResource::class,
                FrameSlotResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ]);
    }
}
