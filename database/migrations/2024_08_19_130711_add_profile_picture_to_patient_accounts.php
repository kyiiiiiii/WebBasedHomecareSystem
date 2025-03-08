<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePictureToPatientAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::table('patient_accounts', function (Blueprint $table) {
            $table->binary('profile_picture')->nullable();
        });

        DB::statement("ALTER TABLE patient_accounts MODIFY profile_picture MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_accounts', function (Blueprint $table) {
            $table->dropIfExist('profile_picture');
        });
    }
}
