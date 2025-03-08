<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetNullOnEactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('appointments', function (Blueprint $table) {
            
            $table->dropForeign(['requested_by_employee']);
            $table->dropForeign(['assigned_employee_id']);

            $table->foreign('requested_by_employee')
                ->references('id')->on('employee_accounts')
                ->onDelete('set null'); 
        
            $table->foreign('assigned_employee_id')
                ->references('id')->on('employee_accounts')
                ->onDelete('set null'); 
        });

      
        Schema::table('care_deliveries', function (Blueprint $table) {
            
            $table->dropForeign(['requested_by_employee']);
            $table->dropForeign(['assigned_employee']);

           
            $table->foreign('requested_by_employee')
                ->references('id')->on('employee_accounts')
                ->onDelete('set null'); 
        
            $table->foreign('assigned_employee')
                ->references('id')->on('employee_accounts')
                ->onDelete('set null'); 
        });
        Schema::table('prescription_requests', function (Blueprint $table) {
            
            $table->dropForeign(['requested_by_employee']);
  
            $table->foreign('requested_by_employee')
                ->references('id')->on('employee_accounts')
                ->onDelete('set null'); 
        
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
            $table->dropForeign(['requested_by_employee']);
            $table->dropForeign(['assigned_employee_id']);
            
            $table->foreign('requested_by_employee')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('assigned_employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::table('care_deliveries', function (Blueprint $table) {
            $table->dropForeign(['requested_by_employee']);
            $table->dropForeign(['assigned_employee']);
            
            $table->foreign('requested_by_employee')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('assigned_employee')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::table('prescription_requests', function (Blueprint $table) {
            $table->dropForeign(['requested_by_employee']);
            
            $table->foreign('requested_by_employee')->references('id')->on('employees')->onDelete('cascade');
        });
    }
}
