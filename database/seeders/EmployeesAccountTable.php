<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class EmployeesAccountTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        // Clear existing records to start fresh (optional)
        DB::table('employee_accounts')->truncate();

        // Seed with sample data
        DB::table('employee_accounts')->insert([
            [
                'username' => 'Admin',
                'email' => 'Test@gmail.com',
                'password' => Hash::make('12345'), // Hashing the password

            ],
            [
                'username' => 'delete1',
                'email' => 'delete1@gmail.com',
                'password' => Hash::make('12345'), // Hashing the password

            ],
            [
                'username' => 'delete2',
                'email' => 'delete2@gmail.com',
                'password' => Hash::make('12345'), // Hashing the password

            ],
            
        ]);
    }
}
