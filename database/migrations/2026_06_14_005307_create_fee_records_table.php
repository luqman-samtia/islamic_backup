<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('fee_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('year');
            $table->tinyInteger('month');                       // 1 = Jan ... 12 = Dec
            $table->decimal('monthly_fee', 10, 2)->default(0);
            $table->decimal('received', 10, 2)->default(0);
            $table->decimal('outstanding', 10, 2)->default(0);
            $table->date('paid_date')->nullable();
            $table->string('proof')->nullable();                // student-uploaded payment screenshot
            $table->string('status')->default('pending');       // pending / received / rejected
            $table->timestamps();

            $table->unique(['user_id', 'year', 'month']);
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_records');
    }
}
