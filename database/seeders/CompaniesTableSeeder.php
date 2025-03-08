<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->truncate();
        DB::table('companies')->insert([
            [
                'address' => ' 89A, Selasar Rokam 11',
                'city' => 'Malaysia',
                'state' => 'Perak',
                'postal_code' => '31350',
                'country' => 'MY',
                'phone_number' => '012-456-7890',
                'website' => 'http://example.com',
                'registration_number' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'address' => '593, Laluan Simee 9',
                'city' => 'Malaysia',
                'state' => 'Perak',
                'postal_code' => '31350',
                'country' => 'MY',
                'phone_number' => '012-2955293',
                'website' => 'http://example2.com', // nullable field
                'registration_number' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
