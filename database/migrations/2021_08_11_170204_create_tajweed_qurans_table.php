<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTajweedQuransTable extends Migration
{
    public function up()
    {
        Schema::create('tajweed_quran', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('number')->nullable();
            $table->integer('ayat_from')->nullable();
            $table->integer('ayat_to')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tajweed_quran');
    }
}
