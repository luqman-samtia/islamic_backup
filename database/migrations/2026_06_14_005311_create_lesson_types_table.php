<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonTypesTable extends Migration
{
    public function up()
    {
        Schema::create('lesson_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();        // slug e.g. quran, qaida, hadith
            $table->string('label');                // display name
            $table->text('columns')->nullable();    // JSON: [{key,label,type}, ...]
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_types');
    }
}
