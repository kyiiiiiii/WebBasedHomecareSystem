<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::info('Running PatientsTableSeeder');

        // Clear existing records to start fresh (optional)
        

        // Predefined data options
        $firstNames = ['John', 'Jane', 'Michael', 'jelly', 'jibet', 'Sarah'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis'];
        $genders = ['Male', 'Female'];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'];
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ'];
        $relationships = ['Parent', 'Sibling', 'Friend'];

        // Generate 100 records
        for ($i = 4; $i <= 100; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            $gender = $genders[array_rand($genders)];
            $city = $cities[array_rand($cities)];
            $state = $states[array_rand($states)];
            $relationship = $relationships[array_rand($relationships)];
            $age = rand(18, 90); // Random age between 18 and 90
            $dob = date('Y-m-d', strtotime("-$age years"));

            DB::table('patients')->insert([
                'name' => $name,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'gender' => $gender,
                'age' => $age,
                'date_of_birth' => $dob,
                'contact' => '012-' . rand(1000000, 9999999),
                'email' => strtolower($firstName . '.' . $lastName . '@example.com'),
                'patient_account_id'=> $i,
                'address_line_1'=> rand(100, 999) . ' Main St',
                'address_line_2'=> 'Apt ' . rand(1, 20),
                'city'=> $city,
                'state'=> $state,
                'postal_code'=> rand(10000, 99999),
                'emergency_contact_name'=> 'Emergency ' . $lastName,
                'emergency_relationship'=> $relationship,
                'emergency_contact'=> '012-' . rand(1000000, 9999999),
                'primary_care_physician'=> rand(1, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

