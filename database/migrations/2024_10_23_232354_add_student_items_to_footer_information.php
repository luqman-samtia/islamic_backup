<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentItemsToFooterInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('footer_information', function (Blueprint $table) {
            $table->json('student_items')->nullable()->after('dynamic_footer_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('footer_information', function (Blueprint $table) {
            $table->dropColumn('student_items');
        });
    }
}
