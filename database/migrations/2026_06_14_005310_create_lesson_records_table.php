<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonRecordsTable extends Migration
{
    public function up()
    {
        // One flexible table holds all three lesson types.
        // Columns not used by a given type simply stay null.
        Schema::create('lesson_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');                 // the student
            $table->string('lesson_type');
            $table->date('lesson_date')->nullable();
            $table->string('day')->nullable();                     // day + date together

            $table->string('attendance')->nullable();              // all types  (dropdown)
            $table->string('course')->nullable();                  // all types  (dropdown)

            // Quran specific
            $table->string('para_name')->nullable();               // dropdown
            $table->string('surah_name')->nullable();              // dropdown
            $table->string('ayat_from')->nullable();
            $table->string('ayat_to')->nullable();

            // Qaida specific
            $table->string('tekhti_number')->nullable();            // dropdown

            // Namaz / Kalmay / Duain specific
            $table->string('select_lesson')->nullable();           // dropdown

            // Common
            $table->string('page_number')->nullable();
            $table->string('line_from')->nullable();
            $table->string('line_to')->nullable();
            $table->text('notes')->nullable();                     // dropdown

            $table->unsignedBigInteger('created_by')->nullable();  // who wrote it
            $table->string('creator_role')->nullable();            // admin / scholar / student
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'lesson_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_records');
    }
}
