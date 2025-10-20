<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $mealCategories = [
            // SALADS (Meal IDs 1-7) - all in salad category
            ['meal_id' => 1, 'category_id' => 3], // پروچیکن سالاد - salad
            ['meal_id' => 2, 'category_id' => 3], // سالاد سزار ایوا - salad
            ['meal_id' => 3, 'category_id' => 3], // سالاد ایتالیانو - salad
            ['meal_id' => 4, 'category_id' => 3], // فارماسالاد - salad
            ['meal_id' => 5, 'category_id' => 3], // ماشروم پروسالاد - salad
            ['meal_id' => 6, 'category_id' => 3], // ویتافروت سالاد - salad
            ['meal_id' => 7, 'category_id' => 3], // پاستا سالاد - salad

            // SANDWICHES (Meal IDs 8-11) - all in sandwich category
            ['meal_id' => 8, 'category_id' => 4], // ساندویچ مرغ پستو - sandwich
            ['meal_id' => 9, 'category_id' => 4], // گرین ساندویچ - sandwich
            ['meal_id' => 10, 'category_id' => 4], // چیز تست - sandwich
            ['meal_id' => 11, 'category_id' => 4], // چیزساندویچ - sandwich

            // BREAKFAST (Meal IDs 12-15) - all in breakfast category
            ['meal_id' => 12, 'category_id' => 9], // تست فرانسوی - breakfast
            ['meal_id' => 13, 'category_id' => 9], // پینات تست - breakfast
            ['meal_id' => 14, 'category_id' => 9], // تست پنیر و خرما - breakfast
            ['meal_id' => 15, 'category_id' => 9], // چیز تست ارده ای - breakfast
        ];

        DB::table('meal_categories')->insert($mealCategories);
    }
}
