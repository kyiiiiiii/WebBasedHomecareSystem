<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilepicRoleidToEmployeeAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_accounts', function (Blueprint $table) {
            // Change to mediumBlob for consistency with patients table
            $table->binary('profile_picture')->nullable();
            
            // Role ID with foreign key constraint
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        // Modify the profile_picture column in the patients table
        DB::statement("ALTER TABLE employee_accounts MODIFY profile_picture MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_accounts', function (Blueprint $table) {
            // Drop the foreign key constraint before dropping the column
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropColumn('profile_picture');
        });
    }
}

