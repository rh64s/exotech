<?php

namespace App\Http\Controllers;

use App\Enums\CharacteristicsType;
use App\Http\Requests\Catalog\CatalogShowRequest;
use App\Http\Resources\ModuleResource;
use App\Models\BodyZone;
use App\Models\FrameSlot;
use App\Models\Module;
use App\Models\ModuleCharacteristic;
use App\Models\ModuleType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    public function indexModules(CatalogShowRequest $request): Response
    {
        $validated = $request->validated();
        $filters = [
            ...$this->catalogFilters($request),
            'saved' => $request->boolean('saved'),
            'interface' => $request->integer('interface') ?: null,
            'body_zones' => array_map('intval', $validated['body_zones'] ?? []),
        ];
        $user = $request->user();
        $modules = Module::query()->doesntHave('frame');

        return Inertia::render('catalog/Modules', [
            'items' => Inertia::scroll(
                fn () => ModuleResource::collection(
                    $this->applyCatalogFilters(clone $modules, $filters)
                        ->with(['moduleType:id,name', 'characteristics', 'bodyZone:id,name'])
                        ->when($filters['saved'], fn (Builder $query) => $query->whereIn(
                            'modules.id', $user?->wishlist()->select('modules.id') ?? [],
                        ))
                        ->when($filters['interface'], fn (Builder $query, int $id) => $query->where('attachment_interface_id', $id))
                        ->when($filters['body_zones'], fn (Builder $query, array $zones) => $query->whereIn('body_zone_id', $zones))
                        ->when($user, fn (Builder $query) => $query->withExists([
                            'wishlistedByUsers as is_in_wishlist' => fn (Builder $query) => $query->whereKey($user->id),
                        ]))
                        ->orderBy('id')
                        ->simplePaginate(9)
                        ->withQueryString(),
                ),
            ),
            'types' => fn () => $this->catalogTypes($modules),
            'characteristic_options' => fn () => $this->characteristicOptions($modules),
            'body_zones' => fn () => BodyZone::query()
                ->whereIn('id', (clone $modules)->select('body_zone_id'))
                ->orderBy('name')->get(['id', 'name']),
            'price_bounds' => fn () => $this->priceBounds($modules),
            'filters' => $filters,
        ]);
    }

    public function indexFrames(CatalogShowRequest $request): Response
    {
        $validated = $request->validated();
        $filters = [
            ...$this->catalogFilters($request),
            'max_weight_g' => isset($validated['max_weight_g']) ? (int) $validated['max_weight_g'] : null,
            'min_total_weight_g' => isset($validated['min_total_weight_g']) ? (int) $validated['min_total_weight_g'] : null,
        ];
        $frames = Module::query()->has('frame');

        return Inertia::render('catalog/Frames', [
            'items' => Inertia::scroll(fn () => ModuleResource::collection(
                $this->applyCatalogFilters(clone $frames, $filters)
                    ->when($filters['max_weight_g'] !== null, fn (Builder $query) => $query
                        ->where('weight_g', '<=', $filters['max_weight_g']))
                    ->when($filters['min_total_weight_g'] !== null, fn (Builder $query) => $query
                        ->whereHas('frame', fn (Builder $frame) => $frame
                            ->where('max_total_weight_g', '>=', $filters['min_total_weight_g'])))
                    ->withAggregate('frame as frame_id', 'id')
                    ->with(['moduleType:id,name'])
                    ->orderBy('id')
                    ->simplePaginate(9)
                    ->withQueryString(),
            )),
            'types' => fn () => $this->catalogTypes($frames),
            'characteristic_options' => fn () => $this->characteristicOptions($frames),
            'price_bounds' => fn () => $this->priceBounds($frames),
            'filters' => $filters,
        ]);
    }

    public function show(Request $request, Module $module): Response
    {
        $module->load(
            'moduleType:id,name',
            'characteristics',
            'frame',
        );
        $frame = $module->frame;

        if ($frame) {
            $frame->load('slots.bodyZone', 'slots.attachmentInterface');
        } else {
            $module->load('bodyZone:id,name', 'attachmentInterface:id,name');
        }

        return Inertia::render('Module', [
            'product' => new ModuleResource($module)->resolve($request),
            ...($frame === null && $request->user() ? [
                'isSaved' => $request->user()->wishlist()->whereKey($module->id)->exists(),
            ] : []),
            'frame' => $frame
                ? [
                    'id' => $frame->id,
                    'weightLimit' => $frame->max_total_weight_g,
                    'slots' => $frame->slots->map(
                        fn (FrameSlot $slot): array => [
                            'id' => $slot->id,
                            'zone' => $slot->bodyZone->name,
                            'interface' => $slot->attachmentInterface->name,
                            'quantity' => $slot->quantity,
                        ],
                    ),
                ]
                : null,
        ]);
    }

    /** @return array{types: list<int>, characteristic_values: list<int>, min_price: float|null, max_price: float|null, search: string} */
    private function catalogFilters(CatalogShowRequest $request): array
    {
        $validated = $request->validated();

        return [
            'types' => array_map('intval', $validated['types'] ?? []),
            'characteristic_values' => array_map('intval', $validated['characteristic_values'] ?? []),
            'min_price' => isset($validated['min_price']) ? (float) $validated['min_price'] : null,
            'max_price' => isset($validated['max_price']) ? (float) $validated['max_price'] : null,
            'search' => $validated['search'] ?? '',
        ];
    }

    /**
     * @param  Builder<Module>  $query
     * @param  array{types: list<int>, characteristic_values: list<int>, min_price: float|null, max_price: float|null, search: string}  $filters
     * @return Builder<Module>
     */
    private function applyCatalogFilters(Builder $query, array $filters): Builder
    {
        if ($filters['characteristic_values'] !== []) {
            $this->filterByCharacteristics($query, $filters['characteristic_values']);
        }

        return $query
            ->when($filters['types'], fn (Builder $query, array $types) => $query->whereIn('module_type_id', $types))
            ->when($filters['min_price'] !== null, fn (Builder $query) => $query->where('price', '>=', $filters['min_price']))
            ->when($filters['max_price'] !== null, fn (Builder $query) => $query->where('price', '<=', $filters['max_price']))
            ->when($filters['search'] !== '', fn (Builder $query) => $query->whereLike('name', '%'.$filters['search'].'%'));
    }

    /**
     * Use one stored row ID per distinct value so filtering can compare values in their original database type.
     *
     * @param  Builder<Module>  $products
     * @return list<array{id: int, name: string, unit: string|null, values: list<array{id: int, label: string}>}>
     */
    private function characteristicOptions(Builder $products): array
    {
        $columns = [
            'characteristics.id as characteristic_id',
            'characteristics.name',
            'characteristics.unit',
            'characteristics.data_type',
            ...CharacteristicsType::valueColumns(),
        ];

        return ModuleCharacteristic::query()
            ->whereIn('module_id', (clone $products)->select('modules.id'))
            ->join('characteristics', 'characteristics.id', '=', 'module_characteristics.characteristic_id')
            ->toBase()
            ->select($columns)
            ->selectRaw('MIN(module_characteristics.id) as option_id')
            ->groupBy('characteristics.id', 'characteristics.name', 'characteristics.unit', 'characteristics.data_type', ...CharacteristicsType::valueColumns())
            ->orderBy('characteristics.name')
            ->orderBy('option_id')
            ->get()
            ->groupBy('characteristic_id')
            ->map(function ($rows): array {
                $characteristic = $rows->first();
                $type = CharacteristicsType::from($characteristic->data_type);
                $column = $type->valueColumn();

                return [
                    'id' => (int) $characteristic->characteristic_id,
                    'name' => $characteristic->name,
                    'unit' => $characteristic->unit,
                    'values' => $rows
                        ->filter(fn (object $row): bool => $row->{$column} !== null
                            && ($type !== CharacteristicsType::String || trim($row->{$column}) !== ''))
                        ->sortBy($column, $type === CharacteristicsType::String ? SORT_NATURAL | SORT_FLAG_CASE : SORT_NUMERIC)
                        ->map(fn (object $row): array => [
                            'id' => (int) $row->option_id,
                            'label' => $type === CharacteristicsType::Boolean
                                ? ((bool) $row->{$column} ? 'Да' : 'Нет')
                                : (string) $row->{$column},
                        ])
                        ->values()
                        ->all(),
                ];
            })
            ->filter(fn (array $option): bool => $option['values'] !== [])
            ->values()
            ->all();
    }

    /**
     * @param  Builder<Module>  $products
     * @param  list<int>  $optionIds
     */
    private function filterByCharacteristics(Builder $products, array $optionIds): void
    {
        $options = ModuleCharacteristic::query()
            ->whereIn('module_id', (clone $products)->select('modules.id'))
            ->whereKey($optionIds)
            ->with('characteristic:id,data_type')
            ->get(['id', 'characteristic_id']);

        if ($options->count() !== count($optionIds)) {
            $products->whereRaw('1 = 0');

            return;
        }

        foreach ($options->groupBy('characteristic_id') as $id => $values) {
            $column = $values->first()->characteristic->data_type->valueColumn();

            $products->whereHas('characteristics', fn (Builder $query) => $query
                ->whereKey($id)
                ->whereIn('module_characteristics.'.$column, ModuleCharacteristic::query()
                    ->whereKey($values->modelKeys())
                    ->select($column)));
        }
    }

    /**
     * @param  Builder<Module>  $products
     * @return Collection<int, ModuleType>
     */
    private function catalogTypes(Builder $products): Collection
    {
        return ModuleType::query()
            ->whereIn('id', (clone $products)->select('module_type_id'))
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * @param  Builder<Module>  $products
     * @return array{min: float|null, max: float|null}
     */
    private function priceBounds(Builder $products): array
    {
        $bounds = (clone $products)->toBase()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        return [
            'min' => isset($bounds->min_price) ? (float) $bounds->min_price : null,
            'max' => isset($bounds->max_price) ? (float) $bounds->max_price : null,
        ];
    }
}
