<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModuleResource;
use App\Models\Characteristic;
use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Catalog', [
            'items' => Inertia::scroll(
                fn () => ModuleResource::collection(
                    Module::query()
                        ->with([
                            'moduleType.category',
                            'characteristics',
                        ])
                        ->orderBy('id')
                        ->paginate(9)
                )
            ),
            'categories' => ModuleCategory::all(),
            'max_price' => Module::max('price'),
            'min_price' => Module::min('price'),
            'characteristics' => Characteristic::all(),
        ]);
    }
}
