<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealsImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $default_meals_images = [
            'images/default-meals-images/breakfast.jpg',
            'images/default-meals-images/salad.jpg',
            'images/default-meals-images/pasta.jpg',
            'images/default-meals-images/sandwich.jpg',
        ];

        foreach ($default_meals_images as $url) {
            // Generate a title/alt based on the filename
            $filename = pathinfo($url, PATHINFO_FILENAME); // e.g., "light"
            $alt = lcfirst(str_replace('-', ' ', $filename)); // e.g., "Light"

            Image::createOrFirst([
                'url' => $url,
                'alt' => $alt,
                'extra' => "Extra info for {$alt}", // You can customize this
            ]);
        }
        $salad_image_id = Image::where('url', $default_meals_images[1])->first()->id;
        $sandwich_image_id = Image::where('url', $default_meals_images[3])->first()->id;
        $breakfast_image_id = Image::where('url', $default_meals_images[0])->first()->id;

        $mealsImages = [
            // SALADS - linked to salad images
            ['meal_id' => 1, 'image_id' => $salad_image_id], // پروچیکن سالاد
            ['meal_id' => 2, 'image_id' => $salad_image_id], // سالاد سزار ایوا
            ['meal_id' => 3, 'image_id' => $salad_image_id], // سالاد ایتالیانو
            ['meal_id' => 4, 'image_id' => $salad_image_id], // فارماسالاد
            ['meal_id' => 5, 'image_id' => $salad_image_id], // ماشروم پروسالاد
            ['meal_id' => 6, 'image_id' => $salad_image_id], // ویتافروت سالاد
            ['meal_id' => 7, 'image_id' => $salad_image_id], // پاستا سالاد

            // SANDWICHES - linked to sandwich images
            ['meal_id' => 8, 'image_id' => $sandwich_image_id], // ساندویچ مرغ پستو
            ['meal_id' => 9, 'image_id' => $sandwich_image_id], // گرین ساندویچ
            ['meal_id' => 10, 'image_id' => $sandwich_image_id], // چیز تست
            ['meal_id' => 11, 'image_id' => $sandwich_image_id], // چیزساندویچ

            // BREAKFAST - linked to breakfast images
            ['meal_id' => 12, 'image_id' => $breakfast_image_id], // تست فرانسوی
            ['meal_id' => 13, 'image_id' => $breakfast_image_id], // پینات تست
            ['meal_id' => 14, 'image_id' => $breakfast_image_id], // تست پنیر و خرما
            ['meal_id' => 15, 'image_id' => $breakfast_image_id], // چیز تست ارده ای
        ];

        DB::table('meals_images')->insert($mealsImages);
    }
}
