<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StaffTableSeeder;
use Database\Seeders\DepartmentTableSeeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(DepartmentTableSeeder::class);
        $this->call(StaffTableSeeder::class);
    }
}
