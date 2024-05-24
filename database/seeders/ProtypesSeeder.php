<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProtypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Them du lieu cho bang Protypes
        DB::table('protypes')->insert([
            [
            'type_name' => 'Cellphone',
            'type_image' => '/cellphone.jpg',
            'created_at' => now(),
            ],
            [
            'type_name' => 'Tablet',
            'type_image' => '/tablet.png',
            'created_at' => now(),
            ],
            [
            'type_name' => 'Tivi',
            'type_image' => '/tv.jpg',
            'created_at' => now(),
            ],
            [
            'type_name' => 'Headphones',
            'type_image' => '/headphones.png',
            'created_at' => now(),
            ],
            [
            'type_name' => 'Speaker',
            'type_image' => '/speaker.png',
            'created_at' => now(),
            ],

        ]);
    }
}
