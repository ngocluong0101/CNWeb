<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ITCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('it_centers')->insert([
            [
                'name' => 'Trung tâm Tin học ABC',
                'location' => '456 Đường Y, TP.HCM',
                'contact_email' => 'contact@abc.com'
            ],
            [
                'name' => 'Trung tâm Tin học XYZ',
                'location' => '789 Đường Z, Đà Nẵng',
                'contact_email' => 'contact@xyz.com'
            ]
        ]);
    }
}
