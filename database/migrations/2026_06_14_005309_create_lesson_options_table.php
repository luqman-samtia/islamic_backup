<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonOptionsTable extends Migration
{
    public function up()
    {
        // These are the "Add Item" dropdown values that the admin can add / change.
        // field_key examples:
        //   quran : attendance, course, para_name, surah_name, notes
        //   qaida : attendance, course, tehti_number, notes
        //   namaz : attendance, course, select_lesson, notes
        Schema::create('lesson_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lesson_type');
            $table->string('field_key');
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_options');
    }
}
