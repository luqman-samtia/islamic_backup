<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFooterInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('skype1')->nullable(true);
            $table->json('skype2')->nullable(true);
            $table->json('phone1')->nullable(true);
            $table->json('phone2')->nullable(true);
            $table->json('whatsapp1')->nullable(true);
            $table->json('whatsapp2')->nullable(true);
            $table->json('email')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('footer_information');
    }
}
