<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
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
            'description' => $this->translations->where('language_id', $lang)->first()->description ?? $this->title,
            'status' => $this->status,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
        ];
        
    }

}
