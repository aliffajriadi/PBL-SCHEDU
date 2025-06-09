<?php

namespace Database\Seeders;

use App\Models\PersonalNote;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // PersonalNote::factory(10)->create();

        $this->call([
            AdminSeeder::class,
            StaffSeeder::class
        ]);
    }
}
