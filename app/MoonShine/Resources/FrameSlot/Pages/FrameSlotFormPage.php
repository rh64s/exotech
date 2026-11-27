<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\FrameSlot\Pages;

use App\Models\SchemeModule;
use App\MoonShine\Resources\FrameSlot\FrameSlotResource;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use Throwable;

/**
 * @extends FormPage<FrameSlotResource>
 */
class FrameSlotFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make(FrameSlotResource::slotFields()),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        $slot = $item->getOriginal();
        $used = $slot?->exists ? SchemeModule::where('frame_slot_id', $slot->id)
            ->groupBy('scheme_id')->selectRaw('count(*) as occupied')->pluck('occupied')->max() : 0;

        return [
            'frame_id' => ['required', 'exists:frames,id', ...($used ? ['in:'.$slot->frame_id] : [])],
            'body_zone_id' => ['required', 'exists:body_zones,id', ...($used ? ['in:'.$slot->body_zone_id] : [])],
            'attachment_interface_id' => ['required', 'exists:attachment_interfaces,id', ...($used ? ['in:'.$slot->attachment_interface_id] : []),
                Rule::unique('frame_slots')->where('frame_id', request('frame_id'))->where('body_zone_id', request('body_zone_id'))->ignore($slot?->id)],
            'quantity' => ['required', 'integer', 'min:'.max(1, $used ?? 0)],
        ];
    }

    /**
     * @param  FormBuilder  $component
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer(),
        ];
    }

    /**
     * @return list<ComponentContract>
     *
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer(),
        ];
    }
}
