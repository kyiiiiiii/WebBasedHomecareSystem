<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdatePatientInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Adding new columns
            $table->string('smoking_status')->nullable();
            $table->string('alcohol_consumption')->nullable();
            $table->string('exercise_habits')->nullable();
            $table->string('dietary_preferences')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('bio')->nullable();
        });

        // Changing the type of medical_history column to MEDIUMBLOB
        DB::statement("ALTER TABLE patients MODIFY medical_history MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Dropping new columns
            $table->dropColumn('smoking_status');
            $table->dropColumn('alcohol_consumption');
            $table->dropColumn('exercise_habits');
            $table->dropColumn('dietary_preferences');
            $table->dropColumn('emergency_contact_number');
            $table->dropColumn('bio');
        });

        // Reverting the type change for medical_history column
        DB::statement("ALTER TABLE patients MODIFY medical_history BLOB");
    }
}
