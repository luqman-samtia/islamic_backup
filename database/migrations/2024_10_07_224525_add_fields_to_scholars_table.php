<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToScholarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scholars', function (Blueprint $table) {
            $table->decimal('salary', 10, 2)->nullable(); // Salary field
            $table->string('phone')->nullable(); // Phone field
            $table->string('address')->nullable(); // Address field
            $table->string('cnic')->nullable(); // CNIC field
            $table->text('notes')->nullable(); // Notes field
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scholars', function (Blueprint $table) {
            $table->dropColumn(['salary', 'phone', 'address', 'cnic', 'notes']);
        });
    }
}
