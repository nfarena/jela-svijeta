<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->lang;

        return [
            'id' => $this->id,
            'title' => $this->translations->where('language_id', $lang)->first()->title ?? $this->title,
            'slug' => $this->slug,
        ];
    }
}
