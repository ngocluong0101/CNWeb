<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Bài 1: Thư viện – Sách
            LibrarySeeder::class,
            BookSeeder::class,

            // Bài 2: Người thuê – Laptop
            RenterSeeder::class,
            LaptopSeeder::class,

            // Bài 3: Trung tâm tin học – Thiết bị
            ITCenterSeeder::class,
            HardwareDeviceSeeder::class,

            // Bài 4: Rạp chiếu – Phim
            CinemaSeeder::class,
            MovieSeeder::class,
        ]);
    }
}
