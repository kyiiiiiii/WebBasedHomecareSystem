<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAssignedEmployeeToAssignedEmployeeIdInAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the old `assigned_employee` column
            $table->dropColumn('assigned_employee');

            // Add the new `assigned_employee_id` column
            $table->unsignedBigInteger('assigned_employee_id')->nullable();

            // Set the `assigned_employee_id` column as a foreign key
            $table->foreign('assigned_employee_id')->references('id')->on('employees')->onDelete('cascade');
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
            // Drop the foreign key constraint
            $table->dropForeign(['assigned_employee_id']);

            // Drop the new `assigned_employee_id` column
            $table->dropColumn('assigned_employee_id');

            // Add the old `assigned_employee` column back
            $table->string('assigned_employee')->nullable();
        });
    }
}
