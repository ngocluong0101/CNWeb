<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HardwareDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hardware_devices')->insert([
            [
                'device_name' => 'Logitech G502',
                'type' => 'Mouse',
                'status' => true,
                'center_id' => 1
            ],
            [
                'device_name' => 'Corsair K95',
                'type' => 'Keyboard',
                'status' => true,
                'center_id' => 1
            ],
            [
                'device_name' => 'Sony WH-1000XM4',
                'type' => 'Headset',
                'status' => false,
                'center_id' => 2
            ]
        ]);
    }
}
