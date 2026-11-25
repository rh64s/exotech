<?php

namespace App\Http\Resources;

use App\Models\Characteristic;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Module
 */
class ModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'module_type' => [
                'id' => $this->moduleType->id,
                'name' => $this->moduleType->name,
                'description' => $this->moduleType->description,
                'category' => [
                    'id' => $this->moduleType->category->id,
                    'name' => $this->moduleType->category->name,
                ],
            ],
            'attachment_interface' => [
                'id' => $this->attachmentInterface->id,
                'name' => $this->attachmentInterface->name,
                'type' => $this->attachmentInterface->type,
            ],
            'body_zone' => $this->bodyZone === null ? null : [
                'id' => $this->bodyZone->id,
                'name' => $this->bodyZone->name,
            ],
            'characteristics' => $this->characteristics
                ->map(fn (Characteristic $characteristic): array => [
                    'id' => $characteristic->id,
                    'name' => $characteristic->name,
                    'value' => $characteristic->pivot->value,
                    'unit' => $characteristic->unit,
                    'data_type' => $characteristic->data_type,
                ])
                ->values(),
            'compatible_modules' => $this->compatibleModules
                ->map(fn (Module $module): array => [
                    'id' => $module->id,
                    'name' => $module->name,
                ])
                ->values(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
