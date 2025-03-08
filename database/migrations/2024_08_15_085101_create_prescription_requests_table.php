<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('patient_name');
            $table->string('contact');
            $table->unsignedBigInteger('prescription_id')->nullable(); // Nullable in case it's not linked to a specific prescription
            $table->string('dosage');
            $table->integer('quantity_requested');
            $table->date('prescription_date');
            $table->string('address_line1');
            $table->string('address_line2')->nullable(); // Nullable as it might be optional
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('status')->default('pending'); // Status of the request
            $table->unsignedBigInteger('requested_by_patient')->nullable();
            $table->unsignedBigInteger('requested_by_employee')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('set null');
            $table->foreign('requested_by_patient')->references('id')->on('patients')->onDelete('set null');
            $table->foreign('requested_by_employee')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_requests');
    }
}


