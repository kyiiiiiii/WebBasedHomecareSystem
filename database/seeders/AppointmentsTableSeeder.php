<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('appointments')->insert([
                'patient_id' => rand(1, 10),
                'location' => null,
                'appointment_date' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                'appointment_time' => Carbon::now()->addHours(rand(1, 8))->format('H:i:s'),
                'status' => 'pending',
                'approved_time' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'appointment_type' => 'MedicalCheckUp',
                'notes' => Str::random(20),
                'requested_by_patient' => null,
                'requested_by_employee' => 1,
                'assigned_employee_id' => null,
            ]);
        }
    }
}
