<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPatientAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    
        Schema::table('patients', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_account_id')->nullable();
    
            // Adding the foreign key constraint
            $table->foreign('patient_account_id')->references('id')->on('patient_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['patient_account_id']);
    
            // Then drop the column
            $table->dropColumn('patient_account_id');
        });
    
        // Finally, drop the patient table
        Schema::dropIfExists('patient_accounts');
    }
}
