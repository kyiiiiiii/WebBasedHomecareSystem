<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requestID');
            $table->unsignedBigInteger('assigned_employee');
            $table->unsignedBigInteger('patientID');
            $table->string('location')->nullable();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('status')->default('Pending');
            $table->timestamp('approved_time')->nullable();
            $table->timestamps();

            $table->foreign('requestID')->references('id')->on('requests');
            $table->foreign('assigned_employee')->references('id')->on('employees');
            $table->foreign('patientID')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
