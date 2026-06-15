<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('lesson_type');
            $table->string('course_name');
            $table->boolean('scholar_can_write')->default(true);   // admin permission for scholar
            $table->boolean('student_can_write')->default(false);  // admin permission for student
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_courses');
    }
}
