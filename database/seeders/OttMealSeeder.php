<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Image as ImageModel;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class OttMealSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory limit for image processing during seeding
        @ini_set('memory_limit', '512M');

        $defaultImagePath = 'images/default-meals-images/ott-meal.jpg';

        // define where thumbnails go
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        $meals = [
            [
                'title' => 'اوتمیل چیا',
                'slug' => 'chia-oatmeal',
                'calories' => 350,
                'nutritional_informations' => [
                    'انرژی' => '350 کیلوکالری',
                    'کربوهیدرات' => '45 گرم',
                    'پروتئین' => '12 گرم',
                    'چربی' => '10 گرم'
                ],
                'ingredients' => ['جو دوسر', 'دانه چیا', 'شیر', 'عسل', 'میوه'],
                'consumable_items' => [
                    'منبع عالی فیبر و پروتئین',
                    'سیری طولانی‌مدت',
                    'اسیدهای چرب امگا 3 از چیا'
                ],
                'contraindications' => [
                    'افراد حساس به گلوتن با احتیاط مصرف کنند',
                    'افراد حساس به لاکتوز مصرف نکنند'
                ],
                'types' => ['diet'],
                'categories' => ['ott-meal'],
                'image_path' => null,
                'price' => 220000,
            ],
            [
                'title' => 'اوتمیل قهوه',
                'slug' => 'coffee-oatmeal',
                'calories' => 380,
                'nutritional_informations' => [
                    'انرژی' => '380 کیلوکالری',
                    'کربوهیدرات' => '48 گرم',
                    'پروتئین' => '13 گرم',
                    'چربی' => '11 گرم'
                ],
                'ingredients' => ['جو دوسر', 'قهوه', 'شیر', 'عسل', 'گردو'],
                'consumable_items' => [
                    'ترکیب انرژی از قهوه و فیبر از جو',
                    'منبع پروتئین و چربی‌های مفید',
                    'سیری طولانی‌مدت'
                ],
                'contraindications' => [
                    'افراد حساس به کافئین مصرف نکنند',
                    'افراد حساس به گلوتن با احتیاط مصرف کنند',
                    'افراد حساس به لاکتوز مصرف نکنند'
                ],
                'types' => ['caffeine'],
                'categories' => ['ott-meal'],
                'image_path' => null,
                'price' => 220000,
            ],
        ];

        // Preload or create related types and category
        $typeModels = collect(['diet', 'caffeine'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['ott-meal'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه اوتمیل‌های سالم و مغذی ایوا.',
                'calories' => $data['calories'],
                'price' => $data['price'],
                'is_vegan' => false,
                'kcal' => $data['calories'],
                'nutritional_informations' => $data['nutritional_informations'],
                'consumable_items' => $data['consumable_items'],
                'contraindications' => $data['contraindications'],
            ]);

            // Attach ingredients
            $ingredientIds = collect($data['ingredients'])->map(function ($title) {
                return Ingredient::firstOrCreate(['title' => $title])->id;
            });
            $meal->ingredients()->sync($ingredientIds);

            // Attach category and type
            $meal->categories()->sync(
                collect($data['categories'])->map(fn($c) => $categoryModels[$c]->id)
            );
            $meal->types()->sync(
                collect($data['types'])->map(fn($t) => $typeModels[$t]->id)
            );

            // Prepare image path
            $imagePath = $data['image_path'] ?? $defaultImagePath;
            $fullImagePath = public_path($imagePath);
            $thumbnailUrl = null;

            // Generate thumbnail if the file exists
            if (File::exists($fullImagePath)) {
                $filename = pathinfo($imagePath, PATHINFO_BASENAME);
                $thumbnailPath = $thumbDir . '/' . $filename;

                if (File::exists($thumbnailPath)) {
                    $thumbnailUrl = 'images/thumbnails/' . $filename;
                } else {
                    // Skip extremely large source files to avoid OOM in GD
                    $fileSizeBytes = File::size($fullImagePath);
                    if ($fileSizeBytes <= 20 * 1024 * 1024) { // 20MB
                        try {
                            // create exact 600x600 thumbnail (crop to cover)
                            $img = Image::read($fullImagePath)
                                ->cover(600, 500)
                                ->save($thumbnailPath);

                            $thumbnailUrl = 'images/thumbnails/' . $filename;
                        } catch (\Throwable $e) {
                            // swallow image errors during seeding; proceed without thumbnail
                        }
                    }
                }
            }

            // Create image record (with thumbnail)
            $image = ImageModel::firstOrCreate(
                ['url' => $imagePath],
                ['thumbnail_url' => $thumbnailUrl]
            );

            $meal->images()->syncWithoutDetaching([$image->id]);
        }
    }
}