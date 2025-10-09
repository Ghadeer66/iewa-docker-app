<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
                'slug' => Str::slug('1سالاد سبز ویژه'),
                'description' => 'سالاد تازه با سبزیجات متنوع و سس مخصوص.',
                'price' => 85000,
                'calories' => 220,
                'image' => 'meals/salad.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'مرغ گریل رژیمی',
                'slug' => Str::slug('1مرغ گریل رژیمی'),
                'description' => 'سینه مرغ گریل شده همراه با سبزیجات بخارپز.',
                'price' => 115000,
                'calories' => 350,
                'image' => 'meals/grilled_chicken.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'پاستای سبزیجات',
                'slug' => Str::slug('1پاستای سبزیجات'),
                'description' => 'پاستا با سس سبک و سبزیجات تازه.',
                'price' => 95000,
                'calories' => 410,
                'image' => 'meals/veg_pasta.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'خوراک ماهی سالمون',
                'slug' => Str::slug('1خوراک ماهی سالمون'),
                'description' => 'ماهی سالمون پخته شده با چاشنی لیمو و سبزیجات.',
                'price' => 175000,
                'calories' => 420,
                'image' => 'meals/salmon.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'پکیج رژیمی روزانه',
                'slug' => Str::slug('پکیج رژیمی روزانه1'),
                'description' => 'ترکیبی از صبحانه، ناهار و عصرانه با کالری کنترل‌شده.',
                'price' => 250000,
                'calories' => 1200,
                'image' => 'meals/diet_package.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Adjust table title if different (e.g. 'meals' -> 'foods')
        DB::table('meals')->insert($meals);
    }
}
