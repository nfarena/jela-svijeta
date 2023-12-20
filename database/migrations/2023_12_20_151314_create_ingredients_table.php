<?php

// create_ingredients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug')->unique();
        });

        Schema::create('ingredient_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title');
            $table->timestamps();

            $table->unique(['ingredient_id', 'language_id']);
        });

        // Foreign key
        Schema::table('ingredient_translations', function (Blueprint $table) {
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredient_translations');
        Schema::dropIfExists('ingredients');
    }
}
