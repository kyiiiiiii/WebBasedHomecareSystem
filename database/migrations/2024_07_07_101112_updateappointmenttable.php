<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Updateappointmenttable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('requestID');
            $table->unsignedBigInteger('requested_by_patient')->nullable();
            $table->unsignedBigInteger('requested_by_employee')->nullable();
            $table->foreign('requested_by_patient')->references('id')->on('patients');
            $table->foreign('requested_by_employee')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the added columns
            $table->dropForeign(['requested_by_patient']);
            $table->dropForeign(['requested_by_employee']);
            $table->dropColumn('requested_by_patient');
            $table->dropColumn('requested_by_employee');

            // Recreate the dropped column
            $table->unsignedBigInteger('requestID');
            // Add foreign key constraints or other column definitions if needed
        });
    }
}
