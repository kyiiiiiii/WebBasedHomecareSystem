<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requested_by_user')->nullable();
            $table->unsignedBigInteger('requested_by_employee')->nullable();
            $table->enum('type', ['appointment', 'service', 'prescription_delivery'])->default('appointment');
            $table->unsignedBigInteger('assigned_healthcare_professional')->nullable();
            $table->string('location');
            $table->date('date');
            $table->time('time');
            $table->text('notes')->nullable();
            $table->string('status')->default('Pending');
            $table->unsignedBigInteger('prescriptionID')->nullable(); // Only if prescription delivery is a request type
            $table->timestamps();
        
            $table->foreign('requested_by_user')->references('id')->on('users');
            $table->foreign('requested_by_employee')->references('id')->on('employees');
            $table->foreign('assigned_healthcare_professional')->references('id')->on('employees');
            $table->foreign('prescriptionID')->references('id')->on('prescriptions');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
