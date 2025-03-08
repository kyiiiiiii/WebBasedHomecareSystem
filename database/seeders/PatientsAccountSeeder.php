<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class PatientsAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patient_accounts')->truncate();

        // Seed with sample data
        DB::table('patient_accounts')->insert([
            [
                'username' => 'Patient1',
                'email' => 'Patient1@gmail.com',
                'password' => Hash::make('12345'), // Hashing the password

            ],
            [
                'username' => 'Patient2',
                'email' => 'Patient2@gmail.com',
                'password' => Hash::make('12345'), // Hashing the password

            ],
            
        ]);
    }
}
