<?php

namespace App\Http\Controllers;

use App\Http\Requests\Constructor\InstallModuleRequest;
use App\Http\Services\SchemeService;
use App\Models\Frame;
use App\Models\FrameSlot;
use App\Models\Module;
use App\Models\Scheme;
use App\Models\SchemeModule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class SchemeController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render("Schemes", [
            "schemes" => $request
                ->user()
                ->schemes()
                ->withCount("installations")
                ->latest("id")
                ->get(),
            "limit" => (int) config("app.schemes.max_per_user"),
        ]);
    }

    public function show(Request $request, Scheme $scheme): Response
    {
        Gate::authorize("update-scheme", $scheme);
        $scheme->load(
            "frame.module",
            "frame.slots.bodyZone",
            "frame.slots.attachmentInterface",
            "installations.module",
        );
        $slots = $scheme->frame->slots;
        $options = $request
            ->user()
            ->wishlist()
            ->whereDoesntHave("frame")
            ->whereIn("body_zone_id", $slots->pluck("body_zone_id"))
            ->whereIn(
                "attachment_interface_id",
                $slots->pluck("attachment_interface_id"),
            )
            ->orderBy("name")
            ->get([
                "modules.id",
                "name",
                "weight_g",
                "body_zone_id",
                "attachment_interface_id",
            ])
            ->groupBy(
                fn(
                    Module $module,
                ): string => "$module->body_zone_id:$module->attachment_interface_id",
            );

        return Inertia::render("Constructor", [
            "scheme" => $scheme->only("id", "name"),
            "frameName" => $scheme->frame->module->name,
            "totalWeight" => $scheme->totalWeightGrams(),
            "weightLimit" => $scheme->frame->max_total_weight_g,
            "slots" => $slots->map(
                fn(FrameSlot $slot): array => [
                    "id" => $slot->id,
                    "zone" => $slot->bodyZone->name,
                    "interface" => $slot->attachmentInterface->name,
                    "body_zone_id" => $slot->body_zone_id,
                    "attachment_interface_id" => $slot->attachment_interface_id,
                    "quantity" => $slot->quantity,
                    "installed" => $scheme->installations
                        ->where("frame_slot_id", $slot->id)
                        ->values()
                        ->map(
                            fn(SchemeModule $installation): array => [
                                "id" => $installation->id,
                                "name" => $installation->module->name,
                            ],
                        ),
                    "options" => $options
                        ->get(
                            "$slot->body_zone_id:$slot->attachment_interface_id",
                            collect(),
                        )
                        ->map(
                            fn(Module $module): array => $module->only(
                                "id",
                                "name",
                                "weight_g",
                            ),
                        ),
                ],
            ),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request, Frame $frame): RedirectResponse
    {
        $scheme = DB::transaction(function () use ($request, $frame): Scheme {
            $limit = (int) config("app.schemes.max_per_user");
            $user = User::query()
                ->lockForUpdate()
                ->findOrFail($request->user()->id);
            if ($user->schemes()->count() >= $limit) {
                throw ValidationException::withMessages([
                    "scheme_limit" => "Не удалось создать сборку. Ваш лимит: {$limit}",
                ]);
            }

            return $user->schemes()->create([
                "frame_id" => $frame->id,
                "name" => $frame->module->name,
                "description" => "Пользовательская сборка",
            ]);
        });

        return to_route("schemes.show", $scheme);
    }

    public function addModule(
        InstallModuleRequest $request,
        Scheme $scheme,
        SchemeService $assembly,
    ): RedirectResponse {
        $assembly->install(
            $scheme,
            $request->integer("frame_slot_id"),
            $request->integer("module_id"),
        );

        return to_route("schemes.show", $scheme);
    }

    public function removeModule(
        Scheme $scheme,
        int $installation,
    ): RedirectResponse {
        Gate::authorize("update-scheme", $scheme);
        $scheme->installations()->findOrFail($installation)->delete();

        return to_route("schemes.show", $scheme);
    }

    public function destroy(Scheme $scheme): RedirectResponse
    {
        Gate::authorize("update-scheme", $scheme);
        $scheme->delete();

        return to_route("schemes.index");
    }
}
