<?php

namespace Database\Seeders;

// MealsTableSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MealsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('meals')->truncate();
        DB::table('meal_translations')->truncate();
        DB::table('meal_tags')->truncate();
        DB::table('meal_ingredients')->truncate();
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            $mealId = DB::table('meals')->insertGetId([
                'category_id' => rand(1, 10), 
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
            ]);

            
            foreach (['hrv', 'eng', 'de', 'it'] as $lang) {
                DB::table('meal_translations')->insert([
                    'meal_id' => $mealId,
                    'language_id' => $lang,
                    'title' => "Title for meal ($mealId) on $lang",
                    'description' => "Description for meal ($mealId) on $lang",
                    'created_at' => $faker->dateTimeThisYear,
                    'updated_at' => $faker->dateTimeThisYear,
                ]);
            }

           
            DB::table('meal_tags')->insert([
                'meal_id' => $mealId,
                'tag_id' => rand(1, 20), 
            ]);

            
            DB::table('meal_ingredients')->insert([
                'meal_id' => $mealId,
                'ingredient_id' => rand(1, 30), 
            ]);
        }
    }
}
