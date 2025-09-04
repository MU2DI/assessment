<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Add this import
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([

            'username' => 'muhamadidude',
            'password' => Hash::make('IQlg2rO2t6WDLtKnmAImtuANobTEnkJsjXhhBc2s06afH5TV06ujC'),
            'full_name' => 'SUPER ADMIN',
            'email' => 'dude@schoolsystem.com',
            'is_admin' => true,
            'is_school_admin' => false,
            'is_data_entry' => false
        ]);
        
        // You can add more sample users here
        User::create([
            'username' => 'School Admin',
            'password' => Hash::make('password'),
            'full_name' => 'SCHOOL ADMIN',
            'email' => 'schooladmin@schoolsystem.com',
            'center_code' => 'DM001', // Assign to a school
            'is_admin' => false,
            'is_school_admin' => true,
            'is_data_entry' => false
            
        ]);
    }
}