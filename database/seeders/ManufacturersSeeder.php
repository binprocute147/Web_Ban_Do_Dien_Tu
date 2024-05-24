<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ManufacturersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('manufacturers')->insert([
            [
                'manu_name' => 'Apple',
                'manu_image' => 'logoapples.png',
                'created_at' => now(),
            ],
            [
                'manu_name' => 'Samsung',
                'manu_image' => 'logosamsung.png',
                'created_at' => now(),
            ],
            [
                'manu_name' => 'Xiaomi',
                'manu_image' => 'logoxiaomi.png',
                'created_at' => now(),
            ],
            [
                'manu_name' => 'Huawei',
                'manu_image' => 'logohuawei.png',
                'created_at' => now(),
            ],
            [
                'manu_name' => 'Google',
                'manu_image' => 'logogoogel.png',
                'created_at' => now(),
            ]

        ]);
    }
}
