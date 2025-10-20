<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $mealTypes = [
            // SALADS - mostly energy type
            ['meal_id' => 1, 'type_id' => 3], // پروچیکن سالاد - energy
            ['meal_id' => 2, 'type_id' => 3], // سالاد سزار ایوا - energy
            ['meal_id' => 3, 'type_id' => 3], // سالاد ایتالیانو - energy
            ['meal_id' => 4, 'type_id' => 2], // فارماسالاد - diet
            ['meal_id' => 5, 'type_id' => 3], // ماشروم پروسالاد - energy
            ['meal_id' => 6, 'type_id' => 3], // ویتافروت سالاد - energy
            ['meal_id' => 7, 'type_id' => 3], // پاستا سالاد - energy

            // SANDWICHES
            ['meal_id' => 8, 'type_id' => 1], // ساندویچ مرغ پستو - light
            ['meal_id' => 9, 'type_id' => 3], // گرین ساندویچ - energy
            ['meal_id' => 10, 'type_id' => 1], // چیز تست - light
            ['meal_id' => 11, 'type_id' => 2], // چیزساندویچ - diet

            // BREAKFAST
            ['meal_id' => 12, 'type_id' => 3], // تست فرانسوی - energy
            ['meal_id' => 13, 'type_id' => 3], // پینات تست - energy
            ['meal_id' => 14, 'type_id' => 1], // تست پنیر و خرما - light
            ['meal_id' => 15, 'type_id' => 3], // چیز تست ارده ای - energy
        ];

        DB::table('meal_type')->insert($mealTypes);
    }
}
