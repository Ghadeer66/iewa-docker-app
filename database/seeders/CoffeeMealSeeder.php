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

class CoffeeMealSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory limit for image processing during seeding
        @ini_set('memory_limit', '512M');

        $defaultImagePath = 'images/default-meals-images/coffee.jpg';

        // define where thumbnails go
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        $meals = [
            [
                'title' => 'دمنوشته بری درینک',
                'slug' => 'berry-herbal-drink',
                'calories' => 45,
                'nutritional_informations' => [
                    'انرژی' => '45 کیلوکالری',
                    'کربوهیدرات' => '10 گرم',
                    'پروتئین' => '0.5 گرم',
                    'چربی' => '0.5 گرم'
                ],
                'ingredients' => ['چای میوه‌ای', 'بیدمشک', 'آب'],
                'consumable_items' => [
                    'خاصیت آرامبخش',
                    'آنتی‌اکسیدان از میوه‌های خشک'
                ],
                'contraindications' => [
                    'در صورت حساسیت غذایی با احتیاط مصرف شود'
                ],
                'types' => ['diet'],
                'categories' => ['coffee'],
                'image_path' => null,
                'price' => 180000,
            ],
            [
                'title' => 'کافی میلک',
                'slug' => 'coffee-milk',
                'calories' => 74,
                'nutritional_informations' => [
                    'انرژی' => '74 کیلوکالری',
                    'کربوهیدرات' => '8 گرم',
                    'پروتئین' => '5 گرم',
                    'چربی' => '2.5 گرم'
                ],
                'ingredients' => ['نسکافه', 'آب', 'شیر', 'شیرین کننده طبیعی'],
                'consumable_items' => [
                    'کالری پایین - مناسب رژیم کاهش وزن',
                    'پروتئین قابل توجه از شیر',
                    'کلسیم بالا برای سلامت استخوان'
                ],
                'contraindications' => [
                    'کسانی که دچار اختلالاتی خواب هستند و افرادیکه به لاکتوز آلرژی دارند مصرف نکنند'
                ],
                'types' => ['caffeine'],
                'categories' => ['coffee'],
                'image_path' => 'images/meals/coffee/coffee-milk.png',
                'price' => 70000,
            ],
            [
                'title' => 'کول لته',
                'slug' => 'cool-latte',
                'calories' => 180,
                'nutritional_informations' => [
                    'انرژی' => '180 کیلوکالری',
                    'کربوهیدرات' => '22 گرم',
                    'پروتئین' => '7 گرم',
                    'چربی' => '6 گرم'
                ],
                'ingredients' => ['قهوه', 'شیر', 'یخ', 'شکر'],
                'consumable_items' => [
                    'نوشیدنی خنک و انرژی‌زا',
                    'کافئین برای افزایش تمرکز'
                ],
                'contraindications' => [
                    'افراد حساس به کافئین مصرف نکنند',
                    'افراد حساس به لاکتوز مصرف نکنند'
                ],
                'types' => ['caffeine'],
                'categories' => ['coffee'],
                'image_path' => 'images/meals/coffee/cool-latte.png',
                'price' => 65000,
            ],
            [
                'title' => 'آمریکانو',
                'slug' => 'americano',
                'calories' => 10,
                'nutritional_informations' => [
                    'انرژی' => '10 کیلوکالری',
                    'کربوهیدرات' => '1 گرم',
                    'پروتئین' => '0.5 گرم',
                    'چربی' => '0 گرم'
                ],
                'ingredients' => ['قهوه', 'آب'],
                'consumable_items' => [
                    'کافئین خالص بدون کالری اضافی',
                    'افزایش انرژی و تمرکز'
                ],
                'contraindications' => [
                    'افراد حساس به کافئین مصرف نکنند',
                    'افراد با فشار خون بالا با احتیاط مصرف کنند'
                ],
                'types' => ['caffeine'],
                'categories' => ['coffee'],
                'image_path' => 'images/meals/coffee/americano.png',
                'price' => 60000,
            ],
            [
                'title' => 'چیلی کافی',
                'slug' => 'chili-coffee',
                'calories' => 120,
                'nutritional_informations' => [
                    'انرژی' => '120 کیلوکالری',
                    'کربوهیدرات' => '15 گرم',
                    'پروتئین' => '3 گرم',
                    'چربی' => '4 گرم'
                ],
                'ingredients' => ['قهوه', 'فلفل قرمز', 'شیر', 'شکر'],
                'consumable_items' => [
                    'ترکیب قهوه و فلفل برای افزایش متابولیسم',
                    'انرژی و تمرکز بالا'
                ],
                'contraindications' => [
                    'افراد حساس به کافئین و فلفل مصرف نکنند',
                    'افراد با مشکلات گوارشی با احتیاط مصرف کنند'
                ],
                'types' => ['caffeine'],
                'categories' => ['coffee'],
                'image_path' => 'images/meals/coffee/chili-coffee.png',
                'price' => 70000,
            ],
        ];

        // Preload or create related types and category
        $typeModels = collect(['diet', 'caffeine'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['coffee'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه دمنوش و قهوه‌های خوشمزه ایوا.',
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
                                ->cover(600, 400)
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
