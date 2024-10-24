<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // สร้างข้อมูล Admin
        DB::table('users')->insert([
            'name' => 'admin',
            'username' => 'Admin Name',
            'phone_number' => '0123456789',
            'address' => '123 Admin Street',
            'password' => Hash::make('admin56789'),
            'level' => 'admin',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // สร้างข้อมูลผู้ใช้ทั่วไป
        DB::table('users')->insert([
            'name' => 'user',
            'username' => 'User Name',
            'phone_number' => '0987654321',
            'address' => '456 User Street',
            'password' => Hash::make('user56789'),
            'level' => 'user',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
