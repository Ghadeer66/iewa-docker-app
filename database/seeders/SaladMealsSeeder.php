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
use Illuminate\Support\Str;

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
        $saladsDir = public_path('images/meals/salads');
        $defaultImageRelative = 'images/default-meals-images/salad.jpg';
        $types = [
            'light',
            'diet',
            'energy',
            'caffeine',
            'school',
        ];

        $categories = [
            'economic',
            'package',
            'salad',
            'sandwich',
            'cake',
            'coffee',
            'drinks',
            'ott-meal',
            'breakfast',
            'dessert',
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
                'price' => 270000,
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
                    'سینه مرغ گریل',
                    'پنیر',
                    'کاهو پیچ',
                    'کلم قرمز',
                    'هویج',
                    'پیازچه',
                    'جعفری',
                    'ریحان',
                    'مغز تخمه آفتابگردان',
                    'کنجد',
                    'بروکلی',
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
                'price' => 295000,
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
                    'سینه مرغ',
                    'کاهو فرانسوی',
                    'گوجه چری',
                    'تخم آفتابگردان',
                    'تخم کتان',
                    'زیتون',
                    'کاپاریس',
                    'پنیر پارمسان',
                    'چوبک شویدی',
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
                'price' => 280000,
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
                    'کاهو فرانسوی',
                    'هویج',
                    'بروکلی',
                    'زیتون سبز و سیاه',
                    'خیار',
                    'گوجه چری',
                    'پنیر فتا',
                    'کینوا',
                    'ذرت',
                    'لوبیا قرمز',
                    'تخم مرغ',
                    'تخم آفتابگردان',
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
                'price' => 250000,
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
                    'بیبی اسفناج',
                    'بروکلی',
                    'هویج',
                    'پیاز',
                    'سیاهدانه',
                    'تخم آفتابگردان',
                    'کدو',
                    'لبو',
                    'لوبیا',
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
                'price' => 295000,
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
                    'بروکلی',
                    'مرغ گریل',
                    'قارچ',
                    'سیب زمینی تنوری',
                    'بیبی اسفناج',
                    'پنیر پارمسان',
                    'دانه چیا',
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
                'price' => 280000,
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
                    'مرغ گریل',
                    'پاستا',
                    'کنجد',
                    'بروکلی',
                    'فلفل دلمه رنگی',
                    'پنیر پارمسان',
                ],
                'contraindications' => ['رژیم گلوتن فری', 'بیماران سلیاکی'],
                'categories' => ['salad'],
                'types' => ['energy'],
                'image_path' => 'images/meals/salads/pasta-salad.png',
            ],
            [
                'title' => 'ویتافروت میکس',
                'slug' => 'vitafruit-mix-salad',
                'kcal' => 180,
                'calories' => 180,
                'nutritional_informations' => [
                    'انرژی' => '180 کیلوکالری',
                    'کربوهیدرات' => '28 گرم',
                    'پروتئین' => '4 گرم',
                    'چربی' => '5 گرم'
                ],
                'ingredients' => ['میوه‌های مختلف', 'ماست', 'عسل'],
                'consumable_items' => [
                    'منبع ویتامین و فیبر',
                    'پروبیوتیک از ماست'
                ],
                'contraindications' => [
                    'افراد حساس به لاکتوز مصرف نکنند',
                    'در صورت حساسیت غذایی با احتیاط مصرف شود'
                ],
                'types' => ['diet'],
                'categories' => ['salad'],
                'image_path' => null,
                'price' => 200000,
            ],
        ];

        foreach ($meals as $data) {
            $meal = Meal::create(collect($data)->except(['categories', 'types', 'ingredients','image_path'])->toArray());

            // relations
            $meal->categories()->sync(collect($data['categories'])->map(fn($c) => $categoryModels[$c]->id));
            $meal->types()->sync(collect($data['types'])->map(fn($t) => $typeModels[$t]->id));

            $ingredientIds = collect($data['ingredients'])->map(fn($title) => Ingredient::firstOrCreate(['title' => $title])->id);
            $meal->ingredients()->sync($ingredientIds);

            // --- handle multi-image logic ---
            $attachedImageIds = [];
            if (File::exists($saladsDir) && File::isDirectory($saladsDir)) {
                $allFiles = collect(File::files($saladsDir))
                    ->filter(fn($f) => preg_match('/\.(png|jpg|jpeg|webp)$/i', $f->getFilename()))
                    ->values();

                // find matching images for the salad slug
                $matched = $allFiles->filter(function ($f) use ($data) {
                    $filename = Str::lower($f->getFilename());
                    $slug = Str::lower($data['slug']);
                    return Str::contains($filename, $slug);
                });

                // process each matched image
                foreach ($matched as $fileInfo) {
                    $relativePath = 'images/meals/salads/' . $fileInfo->getFilename();
                    $filename = pathinfo($fileInfo->getFilename(), PATHINFO_BASENAME);
                    $fullImagePath = public_path($relativePath);
                    $thumbnailUrl = null;

                    // Generate thumbnail only for "-01" images
                    if (Str::contains($filename, '-01')) {
                        $thumbnailPath = $thumbDir . '/' . $filename;
                        if (!File::exists($thumbnailPath)) {
                            try {
                                Image::read($fullImagePath)
                                    ->cover(600, 400)
                                    ->save($thumbnailPath);
                                $thumbnailUrl = 'images/thumbnails/' . $filename;
                            } catch (\Throwable $e) {
                                // silently fail
                            }
                        } else {
                            $thumbnailUrl = 'images/thumbnails/' . $filename;
                        }
                    }

                    $image = ImageModel::firstOrCreate(
                        ['url' => $relativePath],
                        ['thumbnail_url' => $thumbnailUrl]
                    );
                    $attachedImageIds[] = $image->id;
                }
            }

            if (!empty($attachedImageIds)) {
                $meal->images()->syncWithoutDetaching($attachedImageIds);
            } else {
                // fallback to default image with thumbnail
                $defaultFullPath = public_path($defaultImageRelative);
                $defaultThumbUrl = null;

                if (File::exists($defaultFullPath)) {
                    $defaultFilename = pathinfo($defaultImageRelative, PATHINFO_BASENAME);
                    $defaultThumbPath = $thumbDir . '/' . $defaultFilename;
                    if (!File::exists($defaultThumbPath)) {
                        try {
                            Image::read($defaultFullPath)
                                ->cover(600, 400)
                                ->save($defaultThumbPath);
                        } catch (\Throwable $e) {
                        }
                    }
                    $defaultThumbUrl = 'images/thumbnails/' . $defaultFilename;
                }

                $defaultImage = ImageModel::firstOrCreate(
                    ['url' => $defaultImageRelative],
                    ['thumbnail_url' => $defaultThumbUrl]
                );
                $meal->images()->syncWithoutDetaching([$defaultImage->id]);
            }
        }
    }
}
