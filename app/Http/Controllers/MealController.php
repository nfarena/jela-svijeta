<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use App\Models\Meal;
use Illuminate\Http\Request;


class MealController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $mealsQuery = Meal::with('category', 'tags', 'ingredients');
        $tagId = $request->input('tags');
        $categoryId = $request->input('category');
        $ingredientId = $request->input('ingredients');
        $diffTime = $request->input('diff_time');

        if ($categoryId) {
            $mealsQuery->where('category_id', $categoryId);
        }
        if ($tagId) {
            $mealsQuery->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            });
        }
        if ($ingredientId) {
            $mealsQuery->whereHas('ingredients', function ($query) use ($ingredientId) {
                $query->where('ingredients.id', $ingredientId);
            });
        }

        $meals = $mealsQuery->paginate($perPage);
        $mealsResource = MealResource::collection($meals);
        $responseData = [
            'meta' => [
                'current_page' => $meals->currentPage(),
                'total_items' => $meals->total(),
                'per_page' => $meals->perPage(),
                'last_page' => $meals->lastPage(),
                
                
            ],
            'data' => $mealsResource,
        ];
        if ($request->has('diff_time')) {
            foreach ($meals as &$meal) {
                if ($meal->updated_at > $diffTime) {
                    $meal->status = 'modified';
                } elseif ($meal->created_at > $diffTime) {
                    $meal->status = 'created';
                } elseif ($meal->deleted_at > $diffTime) {
                    $meal->status = 'deleted';
                } else {
                    $meal->status = 'created'; 
                }
            }
        }

        return response()->json($responseData);
    }
    
}
