<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Meal;
use App\Models\Image;
use App\Models\MealImage;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $meals = [
            [
                'title' => 'سالاد سبز ویژه',
                'slug' => 'salad',
                'description' => 'سالاد تازه با سبزیجات متنوع و سس مخصوص.',
                'price' => 85000,
                'kcal' => 220,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'مرغ گریل رژیمی',
                'slug' => 'grilled_chicken',
                'description' => 'سینه مرغ گریل شده همراه با سبزیجات بخارپز.',
                'price' => 115000,
                'kcal' => 350,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'پاستای سبزیجات',
                'slug' => 'veg_pasta',
                'description' => 'پاستا با سس سبک و سبزیجات تازه.',
                'price' => 95000,
                'kcal' => 410,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'خوراک ماهی سالمون',
                'slug' => 'salmon',
                'description' => 'ماهی سالمون پخته شده با چاشنی لیمو و سبزیجات.',
                'price' => 175000,
                'kcal' => 420,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'پکیج رژیمی روزانه',
                'slug' => 'diet_package',
                'description' => 'ترکیبی از صبحانه، ناهار و عصرانه با کالری کنترل‌شده.',
                'price' => 250000,
                'kcal' => 1200,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert meals and link images by slug
        DB::table('meals')->insert($meals);

        foreach ($meals as $meal) {
            $slug = $meal['slug'];
            $publicPath = public_path("meals/{$slug}.jpg");
            $storageRelative = "meals/{$slug}.jpg"; // in storage/app/public
            $storageFull = storage_path("app/public/{$storageRelative}");

            // Ensure directory exists
            Storage::disk('public')->makeDirectory('meals');

            // Copy from public if exists (fallbacks possible if needed)
            if (file_exists($publicPath)) {
                copy($publicPath, $storageFull);
            }

            // Create image record pointing to storage path
            $image = Image::firstOrCreate([
                'url' => "{$storageRelative}",
            ], [
                'alt' => $meal['title'],
                'extra' => null,
            ]);

            // Link meal to image
            $mealModel = Meal::where('slug', $slug)->first();
            if ($mealModel && $image) {
                MealImage::firstOrCreate([
                    'meal_id' => $mealModel->id,
                    'image_id' => $image->id,
                ]);
            }
        }
    }
}
