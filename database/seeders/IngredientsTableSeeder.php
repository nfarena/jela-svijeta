<?php

namespace Database\Seeders;

// IngredientsTableSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ingredients')->truncate();
        $faker = Faker::create();

        foreach (range(1, 30) as $index) {
            $ingredientsSlug = 'ingredient-' . $index;
            DB::table('ingredients')->insert([
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
                'slug' =>$ingredientsSlug
            ]);

            foreach (['hrv', 'eng', 'de', 'it'] as $lang) {
                DB::table('ingredient_translations')->insert([
                    'ingredient_id' => $index,
                    'language_id' => $lang,
                    'title' => "Title for ingredient ({$index}) on {$lang}",
                    'created_at' => $faker->dateTimeThisYear,
                    'updated_at' => $faker->dateTimeThisYear,
                ]);
            }
        }
    }
}

