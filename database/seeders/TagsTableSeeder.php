<?php

namespace Database\Seeders;

// TagsTableSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tags')->truncate();
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            $tagsSlug = 'tag-' . $index;
            DB::table('tags')->insert([
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
                'slug'=> $tagsSlug
            ]);

            foreach (['hrv', 'eng', 'de', 'it'] as $lang) {
                DB::table('tag_translations')->insert([
                    'tag_id' => $index,
                    'language_id' => $lang,
                    'title' => "Title for tag ({$index}) on {$lang}",
                    'created_at' => $faker->dateTimeThisYear,
                    'updated_at' => $faker->dateTimeThisYear,
                ]);
            }
        }
    }
}

