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
            'weight_g' => $this->weight_g,
            'frame_id' => $this->whenHas('frame_id', fn () => (int) $this->frame_id),
            'module_type' => [
                'name' => $this->moduleType->name,
            ],
            'attachment_interface' => $this->whenLoaded('attachmentInterface', fn () => [
                'name' => $this->attachmentInterface->name,
            ]),
            'body_zone' => $this->whenLoaded('bodyZone', fn () => [
                'name' => $this->bodyZone->name,
            ]),
            'characteristics' => $this->whenLoaded('characteristics', fn () => $this->characteristics
                ->map(fn (Characteristic $characteristic): array => [
                    'id' => $characteristic->id,
                    'name' => $characteristic->name,
                    'value' => $this->displayValue($characteristic),
                    'unit' => $characteristic->unit,
                ])
                ->values()),
            'is_in_wishlist' => $this->whenHas('is_in_wishlist', fn () => (bool) $this->is_in_wishlist),
        ];
    }

    private function displayValue(Characteristic $characteristic): string
    {
        $value = $characteristic->pivot->getAttribute($characteristic->data_type->valueColumn());

        if ($characteristic->data_type === CharacteristicsType::Boolean && $value !== null) {
            return $value ? 'Да' : 'Нет';
        }

        return (string) $value;
    }
}
