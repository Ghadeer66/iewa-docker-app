<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Category;
use App\Models\Type;
use App\Models\Image as ImageModel;
use App\Models\Ingredient;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class SaladMealsSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory for image processing in seeding
        @ini_set('memory_limit', '512M');

        // ensure thumbnail directory exists
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }
        $types = [
            'light', 'diet', 'energy', 'caffeine', 'school',
        ];

        $categories = [
            'economic', 'package', 'salad', 'sandwich', 'cake', 'coffee', 'drinks', 'ott-meal', 'breakfast', 'dessert',
        ];

        // ensure types and categories exist
        $typeModels = collect($types)->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect($categories)->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        $meals = [
            [
                'title' => 'پروچیکن سالاد',
                'slug' => 'pro-chicken-salad',
                'description' => 'سالاد پروچیکن با مرغ گریل و سبزیجات تازه، مناسب برای افزایش انرژی و تعادل غذایی.',
                'calories' => 330,
                'price' => 180000,
                'is_vegan' => false,
                'kcal' => 330,
                'nutritional_informations' => [
                    'کربوهیدرات' => '24.5 گرم',
                    'پروتئین' => '26.5 گرم',
                    'چربی' => '14.5 گرم',
                ],
                'consumable_items' => [
                    'منبع خوبی از کلسیم و پروتئین به دلیل وجود پنیر',
                    'حاوی چربی‌های مفید برای کنترل فشار خون و تعادل هورمونی زنان',
                ],
                'ingredients' => [
                    'سینه مرغ گریل', 'پنیر', 'کاهو پیچ', 'کلم قرمز', 'هویج',
                    'پیازچه', 'جعفری', 'ریحان', 'مغز تخمه آفتابگردان', 'کنجد', 'بروکلی',
                ],
                'contraindications' => ['مشکلات تیروئیدی', 'شیردهی', 'رژیم کتوژنیک'],
                'categories' => ['salad'],
                'types' => ['energy'],
                'image_path' => 'images/meals/salads/pro-checken-salad.png',
            ],
            [
                'title' => 'سالاد سزار ایوا',
                'slug' => 'sezar-salad',
                'description' => 'سالاد سزار ایوا با مرغ، مغزها و پنیر پارمسان؛ مناسب برای سلامت دستگاه گوارش.',
                'calories' => 263,
                'price' => 170000,
                'is_vegan' => false,
                'kcal' => 263,
                'nutritional_informations' => [
                    'کربوهیدرات' => '19 گرم',
                    'پروتئین' => '25 گرم',
                    'چربی' => '10 گرم',
                ],
                'consumable_items' => [
                    'دارای فیبر بالا برای سلامت دستگاه گوارش',
                    'بهبود کلاژن سازی پوست',
                    'افزایش سطح چربی مفید خون',
                ],
                'ingredients' => [
                    'سینه مرغ', 'کاهو فرانسوی', 'گوجه چری', 'تخم آفتابگردان',
                    'تخم کتان', 'زیتون', 'کاپاریس', 'پنیر پارمسان', 'چوبک شویدی',
                ],
                'contraindications' => ['رژیم کتوژنیک', 'کم کاری تیروئید'],
                'categories' => ['salad'],
                'types' => ['energy'],
                'image_path' => 'images/meals/salads/sezar.png',
            ],
            [
                'title' => 'سالاد ایتالیانو',
                'slug' => 'italiano-salad',
                'description' => 'سالاد ایتالیانو با سبزیجات رنگارنگ و ترکیب بدون گلوتن برای کنترل فشار و چربی خون.',
                'calories' => 350,
                'price' => 185000,
                'is_vegan' => false,
                'kcal' => 350,
                'nutritional_informations' => [
                    'کربوهیدرات' => '23 گرم',
                    'پروتئین' => '23 گرم',
                    'چربی' => '14 گرم',
                ],
                'consumable_items' => [
                    'کنترل فشار و کاهش چربی خون',
                    'خاصیت آنتی‌اکسیدانی و ضد التهابی',
                    'بهبود یبوست',
                ],
                'ingredients' => [
                    'کاهو فرانسوی', 'هویج', 'بروکلی', 'زیتون سبز و سیاه',
                    'خیار', 'گوجه چری', 'پنیر فتا', 'کینوا', 'ذرت', 'لوبیا قرمز',
                    'تخم مرغ', 'تخم آفتابگردان',
                ],
                'contraindications' => ['سنگ کلیه اگزالاتی', 'رژیم کتوژنیک'],
                'categories' => ['salad'],
                'types' => ['energy'],
                'image_path' => 'images/meals/salads/italiano.png',
            ],
            [
                'title' => 'فارماسالاد',
                'slug' => 'pharma-salad',
                'description' => 'سالادی رژیمی با بیبی اسفناج و سبزیجات بخارپز برای تقویت سیستم ایمنی و بینایی.',
                'calories' => 200,
                'price' => 160000,
                'is_vegan' => true,
                'kcal' => 200,
                'nutritional_informations' => [
                    'کربوهیدرات' => '15 گرم',
                    'پروتئین' => '20 گرم',
                    'چربی' => '7 گرم',
                ],
                'consumable_items' => [
                    'تقویت سیستم ایمنی بدن',
                    'پیشگیری از سرطان',
                    'بهبود بینایی',
                ],
                'ingredients' => [
                    'بیبی اسفناج', 'بروکلی', 'هویج', 'پیاز', 'سیاهدانه',
                    'تخم آفتابگردان', 'کدو', 'لبو', 'لوبیا',
                ],
                'contraindications' => ['مشکلات تیروئیدی', 'سنگ کلیه', 'حساسیت به دانه‌ها'],
                'categories' => ['salad'],
                'types' => ['diet'],
                'image_path' => 'images/meals/salads/pharma-salad.png',
            ],
            [
                'title' => 'ماشروم پروسالاد',
                'slug' => 'mushroom-prosalad',
                'description' => 'سالاد ماشروم پرو سالاد سرشار از پروتئین، آنتی‌اکسیدان و فیبر برای تقویت ایمنی بدن.',
                'calories' => 265,
                'price' => 175000,
                'is_vegan' => false,
                'kcal' => 265,
                'nutritional_informations' => [
                    'کربوهیدرات' => '33 گرم',
                    'پروتئین' => '13 گرم',
                    'چربی' => '9 گرم',
                ],
                'consumable_items' => [
                    'منبع ویتامین‌ها و مواد معدنی',
                    'افزایش سیستم ایمنی بدن',
                    'پروتئین بدون چربی',
                ],
                'ingredients' => [
                    'بروکلی', 'مرغ گریل', 'قارچ', 'سیب زمینی تنوری',
                    'بیبی اسفناج', 'پنیر پارمسان', 'دانه چیا',
                ],
                'contraindications' => ['حساسیت غذایی خاص'],
                'categories' => ['salad'],
                'types' => ['energy'],
                'image_path' => 'images/meals/salads/pro-salad.png',
            ],
            [
                'title' => 'پاستا سالاد',
                'slug' => 'pasta-salad',
                'description' => 'پاستا سالاد با مرغ گریل و سبزیجات رنگی؛ وعده‌ای سالم و پرانرژی.',
                'calories' => 360,
                'price' => 190000,
                'is_vegan' => false,
                'kcal' => 360,
                'nutritional_informations' => [
                    'کربوهیدرات' => '35 گرم',
                    'پروتئین' => '40 گرم',
                    'چربی' => '5 گرم',
                ],
                'consumable_items' => [
                    'سرشار از ویتامین و آنتی‌اکسیدان',
                    'افزایش انرژی و تمرکز',
                ],
                'ingredients' => [
                    'مرغ گریل', 'پاستا', 'کنجد', 'بروکلی',
                    'فلفل دلمه رنگی', 'پنیر پارمسان',
                ],
                'contraindications' => ['رژیم گلوتن فری', 'بیماران سلیاکی'],
                'categories' => ['salad'],
                'types' => ['energy'],
                'image_path' => 'images/meals/salads/pasta-salad.png',
            ],
        ];

        foreach ($meals as $data) {
            $meal = Meal::create(collect($data)->except(['categories', 'types', 'ingredients', 'image_path'])->toArray());

            // Attach categories
            $meal->categories()->sync(
                collect($data['categories'])->map(fn($c) => $categoryModels[$c]->id)
            );

            // Attach types
            $meal->types()->sync(
                collect($data['types'])->map(fn($t) => $typeModels[$t]->id)
            );

            // Attach ingredients
            $ingredientIds = collect($data['ingredients'])->map(function ($title) {
                return Ingredient::firstOrCreate(['title' => $title])->id;
            });
            $meal->ingredients()->sync($ingredientIds);

            // Prepare and generate thumbnail if possible
            $imagePath = $data['image_path'] ?? null;
            $thumbnailUrl = null;

            if ($imagePath) {
                $fullImagePath = public_path($imagePath);
                if (File::exists($fullImagePath)) {
                    $filename = pathinfo($imagePath, PATHINFO_BASENAME);
                    $thumbnailPath = $thumbDir . '/' . $filename;

                    if (File::exists($thumbnailPath)) {
                        $thumbnailUrl = 'images/thumbnails/' . $filename;
                    } else {
                        $fileSizeBytes = File::size($fullImagePath);
                        if ($fileSizeBytes <= 20 * 1024 * 1024) { // 20MB
                            try {
                                Image::read($fullImagePath)
                                    ->cover(600, 400)
                                    ->save($thumbnailPath);
                                $thumbnailUrl = 'images/thumbnails/' . $filename;
                            } catch (\Throwable $e) {
                                // ignore and continue without thumbnail
                            }
                        }
                    }
                }
            }

            // Attach image with optional thumbnail
            $image = ImageModel::firstOrCreate(
                ['url' => $imagePath],
                ['thumbnail_url' => $thumbnailUrl]
            );
            $meal->images()->syncWithoutDetaching([$image->id]);
        }
    }
}
