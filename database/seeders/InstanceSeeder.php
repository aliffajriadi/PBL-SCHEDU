<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

use App\Models\Instance;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = Instance::create([
            'email' => 'sma2@gmail.com',
            'password' => Hash::make('password'),
            'instance_name' => 'SMA 2 NEGERI BATAM',
            'phone_no' => '081290909090',
            'address' => 'Batam',
            'folder_name' => 'aaaaaa'
        ]);        

        User::create([
            'name' => 'Ahmad Soebarjo Jr.',
            'email' => 'a@gmail.com',
            'password' => Hash::make('123'),
            'instance_uuid' => $staff->uuid,
            'is_teacher' => true,
            'gender' => 'M',
            'birth_date' => '2005-07-15'
        ]);
        
        User::create([
            'name' => 'Brow Jr.',
            'email' => 'b@gmail.com',
            'password' => Hash::make('123'),
            'instance_uuid' => $staff->uuid,
            'is_teacher' => false,
            'gender' => 'M',
            'birth_date' => '2005-08-16'
        ]);
    }
}
