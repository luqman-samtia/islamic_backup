<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAyatNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quran', function (Blueprint $table) {
            $table->integer('ayat_from')->nullable(true)->after('number');
            $table->integer('ayat_to')->nullable(true)->after('ayat_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quran', function (Blueprint $table) {
            $table->dropColumn('ayat_from');
            $table->dropColumn('ayat_to');
        });
    }
}
