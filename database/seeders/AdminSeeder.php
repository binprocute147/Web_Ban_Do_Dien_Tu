<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // thêm dữ liệu cho bảng admin 
        DB::table('admin')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role'=> 'admin',
                'created_at' => now(),

            ],
            [
                'username' => 'admin1',
                'password' => Hash::make('123456789'),
                'role'=> 'admin',
                'created_at' => now(),
            ],
            [
                'username' => 'admin2',
                'password' => Hash::make('admin2'),
                'role'=> 'admin',
                'created_at' => now(),
            ]
        ]);
    }

}
