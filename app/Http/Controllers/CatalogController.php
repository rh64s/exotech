<?php

namespace App\Http\Controllers;

use App\Http\Requests\Catalog\CatalogShowRequest;
use App\Http\Resources\ModuleResource;
use App\Models\BodyZone;
use App\Models\Characteristic;
use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\ModuleType;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    public function index(CatalogShowRequest $request): Response
    {
        foreach (['body_zones', 'types', 'categories'] as $filter) {
            $request[$filter] = array_map('intval', $request[$filter] ?? []);
        }

        foreach (['min_price', 'max_price'] as $filter) {
            if (isset($request[$filter])) {
                $request[$filter] = (float) $request[$filter];
            }
        }

        return Inertia::render('Catalog', [
            'items' => Inertia::scroll(
                fn () => ModuleResource::collection(
                    Module::query()
                        ->with([
                            'moduleType.category',
                            'characteristics',
                            'bodyZone',
                            'attachmentInterface',
                        ])
                        ->when(
                            $request['body_zones'] ?? [],
                            fn (
                                Builder $query,
                                array $bodyZones,
                            ) => $query->whereIn('body_zone_id', $bodyZones),
                        )
                        ->when(
                            $request['types'] ?? [],
                            fn (Builder $query, array $types) => $query->whereIn(
                                'module_type_id',
                                $types,
                            ),
                        )
                        ->when(
                            $request['categories'] ?? [],
                            fn (
                                Builder $query,
                                array $categories,
                            ) => $query->whereHas(
                                'moduleType',
                                fn (
                                    Builder $moduleTypes,
                                ) => $moduleTypes->whereIn(
                                    'category_id',
                                    $categories,
                                ),
                            ),
                        )
                        ->when(
                            isset($request['min_price']),
                            fn (Builder $query) => $query->where(
                                'price',
                                '>=',
                                $request['min_price'],
                            ),
                        )
                        ->when(
                            isset($request['max_price']),
                            fn (Builder $query) => $query->where(
                                'price',
                                '<=',
                                $request['max_price'],
                            ),
                        )
                        ->orderBy('id')
                        ->paginate(9)
                        ->withQueryString(),
                ),
            ),
            'categories' => ModuleCategory::query()->get(['id', 'name']),
            'types' => ModuleType::query()->get(['id', 'name', 'category_id']),
            'body_zones' => BodyZone::query()->get(['id', 'name', 'parent_id']),
            'max_price' => Module::max('price'),
            'min_price' => Module::min('price'),
            'characteristics' => Characteristic::all(),
            'filters' => [
                'body_zones' => $request['body_zones'] ?? [],
                'types' => $request['types'] ?? [],
                'categories' => $request['categories'] ?? [],
                'min_price' => $request['min_price'] ?? null,
                'max_price' => $request['max_price'] ?? null,
            ],
        ]);
    }

    public function show(Request $request)
    {
        return Inertia::render('module/Module', [
            'module' => Module::find($request->get('id'))->with(),
            '',
        ]);
    }
}
