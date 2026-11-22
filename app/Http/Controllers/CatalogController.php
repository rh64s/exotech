<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModuleResource;
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
                            'compatibleModules',
                        ])
                        ->orderBy('id')
                        ->paginate(3)
                )
            ),
            'categories' => ModuleCategory::all()
        ]);
    }
}
