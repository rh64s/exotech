<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\FrameSlot;

use App\Models\AttachmentInterface;
use App\Models\BodyZone;
use App\Models\Frame;
use App\Models\FrameSlot;
use App\MoonShine\Resources\FrameSlot\Pages\FrameSlotDetailPage;
use App\MoonShine\Resources\FrameSlot\Pages\FrameSlotFormPage;
use App\MoonShine\Resources\FrameSlot\Pages\FrameSlotIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;

/**
 * @extends ModelResource<FrameSlot, FrameSlotIndexPage, FrameSlotFormPage, FrameSlotDetailPage>
 */
class FrameSlotResource extends ModelResource
{
    protected string $model = FrameSlot::class;

    protected string $title = 'Крепления';

    public static function slotFields(): array
    {
        return [
            ID::make(),
            Select::make('Каркас', 'frame_id')->options(fn (): array => Frame::with('module')->get()->pluck('module.name', 'id')->all())->required(),
            Select::make('Зона', 'body_zone_id')->options(fn (): array => BodyZone::pluck('name', 'id')->all())->required(),
            Select::make('Интерфейс', 'attachment_interface_id')->options(fn (): array => AttachmentInterface::pluck('name', 'id')->all())->required(),
            Number::make('Количество мест', 'quantity')->min(1)->required(),
        ];
    }

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            FrameSlotIndexPage::class,
            FrameSlotFormPage::class,
            FrameSlotDetailPage::class,
        ];
    }
}
