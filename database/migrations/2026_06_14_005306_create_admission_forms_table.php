<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionFormsTable extends Migration
{
    public function up()
    {
        Schema::create('admission_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('roll_no')->nullable();      // admin assigns
            $table->string('pic')->nullable();          // student photo
            $table->string('student_name');
            $table->string('father_name')->nullable();
            $table->string('course')->nullable();
            $table->string('age')->nullable();
            $table->string('fee')->nullable();          // admin assigns
            $table->string('phone_no')->nullable();
            $table->date('admission_date')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->index('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admission_forms');
    }
}
