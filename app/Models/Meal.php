<?php

namespace App\Models;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'meal_tags');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class,'meal_ingredients');
    }
    public function translations()
    {
        return $this->hasMany(MealTranslation::class, 'meal_id');
    }


}
