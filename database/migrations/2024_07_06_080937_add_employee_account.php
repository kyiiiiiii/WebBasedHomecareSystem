<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('employee_accounts', function (Blueprint $table) {
        $table->id();
        $table->string('username')->unique();
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    });

    Schema::table('employees', function (Blueprint $table) {
        $table->unsignedBigInteger('employee_account_id')->nullable();

        // Adding the foreign key constraint
        $table->foreign('employee_account_id')->references('id')->on('EmployeeAccounts');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    // Reverse the changes in the requests table first
    Schema::table('employees', function (Blueprint $table) {
        // Drop the foreign key first
        $table->dropForeign(['employee_account_id']);

        // Then drop the column
        $table->dropColumn('employee_account_id');
    });

    // Finally, drop the employee_accounts table
    Schema::dropIfExists('employee_accounts');
}
}
