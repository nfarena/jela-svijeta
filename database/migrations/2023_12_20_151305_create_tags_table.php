<?php

// create_tags_table.php
// create_ingredients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug')->unique();
        });

        Schema::create('tag_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title');
            $table->timestamps();
            $table->unique(['tag_id', 'language_id']);
        });

        // Foreign key
        Schema::table('tag_translations', function (Blueprint $table) {
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tag_translations');
        Schema::dropIfExists('tags');
    }
}
