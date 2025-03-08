<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::info('Running EmployeesTableSeeder');

        // Clear existing records to start fresh (optional)
        DB::table('employees')->truncate();

        // Seed with sample data
        DB::table('employees')->insert([
            [
                'name' => 'John Doe',
                'dob' => '1980-02-10',
                'gender' => 'Male',
                'bio'=>'Nice to meet you',
                'address' => '123 Main St',
                'state' => 'California',
                'city' => 'Los Angeles',
                'email' => 'john.doe@example.com',
                'contact_number' => '555-1234',
                'emergency_contact_number' => '555-4321',
                'emergency_contact_name' => 'Lim Kian Yi',
                'religion' => 'buddha',
                'department' => 'HR',
                'role' => 'Nurse',
                'status' => 'Retain',
                'race' => 'Chinese',
                'type' => 'Fulltime',
                'admission_date' => '2020-01-01',
                'employee_account_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
