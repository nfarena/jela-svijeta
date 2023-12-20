<?php

namespace Database\Seeders;

// CategoriesTableSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->truncate();
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $categorySlug = 'category-' . $index;

            DB::table('categories')->insert([
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
                'slug' => $categorySlug,
            ]);

            foreach (['hrv', 'eng', 'de', 'it'] as $lang) {
                DB::table('category_translations')->insert([
                    'category_id' => $index,
                    'language_id' => $lang,
                    'title' => "Title for category ({$index}) on {$lang}",
                    'created_at' => $faker->dateTimeThisYear,
                    'updated_at' => $faker->dateTimeThisYear,
                ]);
            }
        }
    }
}

