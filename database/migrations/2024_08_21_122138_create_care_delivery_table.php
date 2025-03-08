<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key
            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            $table->string('care_delivery_type', 50); // Type of care delivery (e.g., Medical Checkup)
            $table->date('date'); // Date of the care delivery
            $table->time('time'); // Time of the care delivery
            $table->text('notes')->nullable(); // Additional notes (optional)
            $table->unsignedBigInteger('requested_by_employee')->nullable(); // Foreign key to employees table
            $table->unsignedBigInteger('requested_by_patient_account')->nullable();
            $table->unsignedBigInteger('assigned_employee')->nullable(); // Foreign key to employees table
            $table->timestamps(); // created_at and updated_at timestamps
            $table->string('status');
            // Foreign key constraints
            $table->foreign('requested_by_patient_account')->references('id')->on('patient_accounts')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('requested_by_employee')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('assigned_employee')->references('id')->on('employees')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('care_deliveries');
    }
}
