<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParaNoToTajweedQuran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tajweed_quran', function (Blueprint $table) {
            $table->unsignedTinyInteger('para_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tajweed_quran', function (Blueprint $table) {
            $table->dropColumn('para_no');
        });
    }
}
