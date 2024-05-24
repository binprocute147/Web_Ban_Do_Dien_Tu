<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'user_name' => 'user1',
                'password' => Hash::make('123'),
                'first_name' => 'Khoa',
                'last_name' => 'Nguyễn Tấn',
                'address' => 'Bình Định',
                'email' => 'nguyentankhoa@gmail.com',
                'created_at' => now(),
            ],
            [
                'user_name' => 'user2',
                'password' => Hash::make('123'),
                'first_name' => 'Hồng',
                'last_name' => 'Nguyễn văn',
                'address' => 'Bình Định',
                'email' => 'nguyenvanhong@gmail.com',
                'created_at' => now(),
            ],
            [
                'user_name' => 'user3',
                'password' => Hash::make('password3'),
                'first_name' => 'Bin',
                'last_name' => 'Nguyễn Tấn',
                'address' => 'Phú Yên',
                'email' => 'nguyentanbin@gmail.com',
                'created_at' => now(),
            ],
            [
                'user_name' => 'user4',
                'password' => Hash::make('password4'),
                'first_name' => 'Văn',
                'last_name' => 'Nguyễn ',
                'address' => 'Dak Lak',
                'email' => 'nguyenvan@gmail.com',
                'created_at' => now(),
            ],
            [
                'user_name' => 'user5',
                'password' => Hash::make('password5'),
                'first_name' => 'Yến',
                'last_name' => 'Nguyễn Thị',
                'address' => 'Khánh Hòa',
                'email' => 'nguyenthiyen@gmail.com',
                'created_at' => now(),
            ]
        ]);
    }
}
