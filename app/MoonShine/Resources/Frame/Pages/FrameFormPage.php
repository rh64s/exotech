<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Frame\Pages;

use App\Models\Module;
use App\Models\SchemeModule;
use App\MoonShine\Resources\Frame\FrameFields;
use App\MoonShine\Resources\Frame\FrameResource;
use App\MoonShine\Resources\FrameSlot\FrameSlotResource;
use Illuminate\Validation\Rule;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use Throwable;

/**
 * @extends FormPage<FrameResource>
 */
class FrameFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make(FrameFields::only([
                'id',

                'module_id',
                'max_total_weight_g',
                'max_power_output',
            ])),
            HasMany::make('Крепления', 'slots', resource: FrameSlotResource::class)->creatable(),
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
        return [
            'module_id' => ['required', 'integer', 'exists:modules,id', Rule::unique('frames')->ignore($item->getOriginal()?->id),
                Rule::notIn(SchemeModule::distinct()->pluck('module_id'))],
            'max_total_weight_g' => ['required', 'integer', 'min:'.(Module::find(request()->integer('module_id'))?->weight_g ?? 1)],
            'max_power_output' => ['nullable', 'integer', 'min:0'],
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
