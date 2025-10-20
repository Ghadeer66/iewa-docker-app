<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['title' => 'economic'],
            ['title' => 'package'],
            ['title' => 'salad'],
            ['title' => 'sandwich'],
            ['title' => 'cake'],
            ['title' => 'coffee'],
            ['title' => 'drinks'],
            ['title' => 'ott-meal'],
            ['title' => 'breakfast'],
            ['title' => 'dessert'],
        ];

        DB::table('categories')->insert($categories);
    }
}
