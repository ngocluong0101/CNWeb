<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            DB::table('computers')->insert([
                'computer_name'     => 'Lab-' . $faker->bothify('PC-##'),
                'model'             => $faker->randomElement([
                    'Dell Optiplex 7090',
                    'HP ProDesk 400',
                    'Lenovo ThinkCentre'
                ]),
                'operating_system'  => $faker->randomElement([
                    'Windows 10 Pro',
                    'Windows 11 Pro',
                    'Ubuntu 22.04'
                ]),
                'processor'         => $faker->randomElement([
                    'Intel Core i5-11400',
                    'Intel Core i7-10700',
                    'Ryzen 5 5600G'
                ]),
                'memory'            => $faker->randomElement([8, 16, 32]),
                'available'         => $faker->boolean,
            ]);
        }
    }
}
