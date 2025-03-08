<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientID');
            $table->unsignedBigInteger('prescribed_by_employee');
            $table->date('prescription_date');
            $table->text('medicine');
            $table->string('dosage');
            $table->text('instructions')->nullable();
            $table->timestamps();
        
            $table->foreign('patientID')->references('id')->on('patients');
            $table->foreign('prescribed_by_employee')->references('id')->on('employees');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
