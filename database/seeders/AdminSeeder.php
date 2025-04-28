<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'onlydev1',
            'password' => Hash::make('password')
        ]);
        
        Admin::create([
            'username' => 'iamadmin',
            'password' => Hash::make('password')
        ]);
    }
}
