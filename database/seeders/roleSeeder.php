<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        // Seed with sample data
        DB::table('roles')->insert([
            [
                'role_name' => 'admin'
            ],
            [
               'role_name' => 'employee'
            ],
            
        ]);
    }
}
