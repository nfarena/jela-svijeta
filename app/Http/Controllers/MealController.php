<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(StorePostRequest $request)
    {
        $perPage = $request->input('per_page', 10);
        $tagId = $request->input('tags');
        $categoryId = $request->input('category');
        $ingredientId = $request->input('ingredients');
        $diffTime = $request->input('diff_time');
        $with = $request->input('with', []);

        if (!is_array($with)) {
            $with = explode(',', $with);
        }

        $mealsQuery = $diffTime ? Meal::withTrashed() : Meal::query();

        // Load requested relationships dynamically
        foreach ($with as $relation) {
            $mealsQuery->with($relation);
        }

        if ($categoryId) {
            $mealsQuery->where('category_id', $categoryId);
        }

        if ($tagId) {
            $tagIds = explode(',', $tagId);
            $mealsQuery->whereHas('tags', function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds);
            });
        }

        if ($ingredientId) {
            $mealsQuery->whereHas('ingredients', function ($query) use ($ingredientId) {
                $query->where('ingredients.id', $ingredientId);
            });
        }

        $meals = $mealsQuery->paginate($perPage);
        $mealsResource = MealResource::collection($meals);

        foreach ($meals as &$meal) {
            if ($diffTime) {
                if ($meal->deleted_at > $diffTime) {
                    $meal->status = 'deleted';
                } elseif ($meal->updated_at > $diffTime) {
                    $meal->status = 'modified';
                } elseif ($meal->created_at > $diffTime) {
                    $meal->status = 'created';
                }
            } else {
                $meal->status = 'created';
            }
        }

        return response()->json([
            'meta' => [
                'current_page' => $meals->currentPage(),
                'total_items' => $meals->total(),
                'per_page' => $meals->perPage(),
                'last_page' => $meals->lastPage(),
            ],
            'data' => $mealsResource,
        ]);
    }
}
