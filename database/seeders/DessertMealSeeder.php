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

class DessertMealSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory limit for image processing during seeding
        @ini_set('memory_limit', '512M');

        $defaultImagePath = 'images/default-meals-images/dessert.jpg';

        // define where thumbnails go
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        $meals = [
            [
                'title' => 'دسر شکلاتی',
                'slug' => 'chocolate-dessert',
                'calories' => 280,
                'nutritional_informations' => [
                    'انرژی' => '280 کیلوکالری',
                    'کربوهیدرات' => '35 گرم',
                    'پروتئین' => '6 گرم',
                    'چربی' => '12 گرم'
                ],
                'ingredients' => ['شکلات', 'شیر', 'خامه', 'شکر'],
                'consumable_items' => [
                    'منبع انرژی فوری',
                    'حاوی آنتی‌اکسیدان از کاکائو'
                ],
                'contraindications' => [
                    'افراد حساس به لاکتوز مصرف نکنند',
                    'در صورت حساسیت غذایی با احتیاط مصرف شود'
                ],
                'types' => ['energy'],
                'categories' => ['dessert'],
                'image_path' => null,
                'price' => 220000,
            ],
            [
                'title' => ' قهوه شکلات',
                'slug' => 'two-tone-coffee-chocolate-dessert',
                'calories' => 310,
                'nutritional_informations' => [
                    'انرژی' => '310 کیلوکالری',
                    'کربوهیدرات' => '38 گرم',
                    'پروتئین' => '7 گرم',
                    'چربی' => '14 گرم'
                ],
                'ingredients' => ['قهوه', 'شکلات', 'خامه', 'شکر'],
                'consumable_items' => [
                    'ترکیب قهوه و شکلات برای افزایش انرژی',
                    'حاوی کافئین طبیعی'
                ],
                'contraindications' => [
                    'افراد حساس به کافئین مصرف نکنند',
                    'افراد حساس به لاکتوز مصرف نکنند'
                ],
                'types' => ['energy'],
                'categories' => ['dessert'],
                'image_path' => null,
                'price' => 240000,
            ],
            [
                'title' => 'ویتافروت میکس',
                'slug' => 'vitafruit-mix-dessert',
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
                'categories' => ['dessert'],
                'image_path' => null,
                'price' => 200000,
            ],
            [
                'title' => 'دسر قهوه',
                'slug' => 'coffee-dessert',
                'calories' => 290,
                'nutritional_informations' => [
                    'انرژی' => '290 کیلوکالری',
                    'کربوهیدرات' => '32 گرم',
                    'پروتئین' => '8 گرم',
                    'چربی' => '13 گرم'
                ],
                'ingredients' => ['قهوه', 'خامه', 'شکر', 'ژلاتین'],
                'consumable_items' => [
                    'انرژی از قهوه',
                    'منبع کافئین طبیعی'
                ],
                'contraindications' => [
                    'افراد حساس به کافئین مصرف نکنند',
                    'افراد حساس به لاکتوز مصرف نکنند'
                ],
                'types' => ['caffeine'],
                'categories' => ['dessert'],
                'image_path' => null,
                'price' => 230000,
            ],
        ];

        // Preload or create related types and category
        $typeModels = collect(['energy', 'diet', 'caffeine'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['dessert'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه دسرهای خوشمزه و سالم ایوا.',
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