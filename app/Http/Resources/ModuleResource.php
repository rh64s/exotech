<?php

namespace App\Http\Resources;

use App\Enums\CharacteristicsType;
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
                    'value' => $this->displayValue($characteristic),
                    'unit' => $characteristic->unit,
                    'data_type' => $characteristic->data_type,
                ])
                ->values(),
            'compatible_modules' => [],
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    private function displayValue(Characteristic $characteristic): string
    {
        $value = $characteristic->pivot->getAttribute($characteristic->data_type->valueColumn());

        if ($characteristic->data_type === CharacteristicsType::Boolean && $value !== null) {
            return $value ? 'true' : 'false';
        }

        return (string) $value;
    }
}
