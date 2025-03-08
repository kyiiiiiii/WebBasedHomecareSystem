<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEcgData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecg_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id'); // Define patient_id as an unsigned big integer
            $table->integer('ecg_value');
            $table->timestamps();

            // If patient_id is a foreign key to a patients table
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecg_data'); // Correct method to drop the table
    }
}
