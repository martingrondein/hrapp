<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StaffTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('staff')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'date_of_birth' => $faker->date(),
                'home_address' => $faker->address,
                'city' => $faker->city,
                'country' => $faker->country,
                'hire_date' => $faker->dateTimeThisYear,
                'department_id' => rand(1, 10),
                'position' => $faker->word(),
                'notice_period' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
