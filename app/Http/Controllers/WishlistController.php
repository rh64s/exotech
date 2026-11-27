<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Request $request, Module $module): RedirectResponse
    {
        abort_if($module->frame()->exists(), 404);

        $request->user()->wishlist()->syncWithoutDetaching([$module->id]);

        return back();
    }

    public function destroy(Request $request, Module $module): RedirectResponse
    {
        $request->user()->wishlist()->detach($module->id);

        return back();
    }
}
