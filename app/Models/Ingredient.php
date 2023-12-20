<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_ingredients');
    }
    public function translations()
    {
        return $this->hasMany(IngredientTranslation::class);
    }


}
