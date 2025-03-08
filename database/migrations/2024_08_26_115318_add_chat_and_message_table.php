<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChatAndMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the chats table
        Schema::create('chats', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at columns
        });

        // Create the messages table
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade');
            $table->enum('sender_type', ['patient', 'employee']); // Who sent the message
            $table->bigInteger('sender_id'); // ID of the sender
            $table->text('message'); // The message content
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('chats');
    }
}
