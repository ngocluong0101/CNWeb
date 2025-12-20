<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('issues')->insert([
                'computer_id'   => $faker->numberBetween(1, 20),
                'reported_by'   => $faker->name,
                'reported_date' => $faker->dateTimeBetween('-30 days', 'now'),
                'description'   => $faker->sentence(10),
                'urgency'       => $faker->randomElement(['Low', 'Medium', 'High']),
                'status'        => $faker->randomElement([
                    'Open',
                    'In Progress',
                    'Resolved'
                ]),
            ]);
        }
    }
}
