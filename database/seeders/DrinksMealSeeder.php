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

class DrinksMealSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory limit for image processing during seeding
        @ini_set('memory_limit', '512M');

        $defaultImagePath = 'images/default-meals-images/drinks.jpg';

        // define where thumbnails go
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        $meals = [
            [
                'title' => 'پرتقال',
                'slug' => 'orange-drink',
                'calories' => 80,
                'nutritional_informations' => [
                    'انرژی' => '80 کیلوکالری',
                    'کربوهیدرات' => '20 گرم',
                    'پروتئین' => '1 گرم',
                    'چربی' => '0.5 گرم'
                ],
                'ingredients' => ['پرتقال', 'آب'],
                'consumable_items' => [
                    'منبع عالی ویتامین C',
                    'آنتی‌اکسیدان طبیعی'
                ],
                'contraindications' => [
                    'در صورت حساسیت غذایی با احتیاط مصرف شود'
                ],
                'types' => ['light'],
                'categories' => ['drinks'],
                'image_path' => 'images/meals/drinks/orange-drink.png',
                'price' => 60000,
            ],
            [
                'title' => 'چاکلت میلک',
                'slug' => 'chocolate-milk',
                'calories' => 153,
                'nutritional_informations' => [
                    'انرژی' => '153 کیلوکالری',
                    'کربوهیدرات' => '20 گرم',
                    'پروتئین' => '7 گرم',
                    'چربی' => '5 گرم'
                ],
                'ingredients' => ['شیر', 'پودر کاکائو', 'عسل چندگیاه'],
                'consumable_items' => [
                    'منبع خوبی از کلسیم و پروتئین',
                    'دارای فلاونوئیدها و خواص آنتی‌اکسیدانی'
                ],
                'contraindications' => [
                    'برای افراد دیابتی و افرادی که عدم تحمل لاکتوز دارند توصیه نمی‌شود'
                ],
                'types' => ['energy'],
                'categories' => ['drinks'],
                'image_path' => 'images/meals/drinks/chocolate-milk.png',
                'price' => 180000,
            ],
            [
                'title' => 'معجون انرژی درینک',
                'slug' => 'energy-drink-mix',
                'calories' => 450,
                'nutritional_informations' => [
                    'انرژی' => '450 کیلوکالری',
                    'کربوهیدرات' => '70 گرم',
                    'پروتئین' => '25 گرم',
                    'چربی' => '12 گرم'
                ],
                'ingredients' => ['شیر', 'گردو', 'نارگیل', 'خرما', 'کنجد', 'موز'],
                'consumable_items' => [
                    'دارای پتاسیم بالا بعلت وجود موز و خرما',
                    'دارای آهن قابل توجه بخاطر کنجد و گردو و خرما',
                    'منبع خوبی از چربی‌های سالم و غیراشباع',
                    'به‌دلیل ترکیب هوشمندانه‌ای که دارد، تقریباً یک وعده غذایی کامل محسوب می‌شود'
                ],
                'contraindications' => [
                    'برای افراد دیابتی و افرادی که عدم تحمل لاکتوز دارند توصیه نمی‌شود'
                ],
                'types' => ['energy'],
                'categories' => ['drinks'],
                'image_path' => null,
                'price' => 140000,
            ],
            [
                'title' => 'رد فروت میکس',
                'slug' => 'red-fruit-mix',
                'calories' => 130,
                'nutritional_informations' => [
                    'انرژی' => '130 کیلوکالری',
                    'کربوهیدرات' => '32 گرم',
                    'پروتئین' => '1 گرم',
                    'چربی' => '0.5 گرم'
                ],
                'ingredients' => ['کنسانتره انار', 'کنسانتره آلو قرمز', 'کنسانتره تمشک', 'کنسانتره شاهتوت', 'شکر قهوه‌ای', 'آب آشامیدنی'],
                'consumable_items' => [
                    'بدلیل وجود رنگدانه‌های آنتوسیانین سرشار از آنتی‌اکسیدان و ویتامین C می‌باشد',
                    'دارای پلی‌فنل‌های ضدالتهاب می‌باشد'
                ],
                'contraindications' => [
                    'برای بیماران دیابتی و افرادیکه فشارخون پایین دارند توصیه نمی‌شود'
                ],
                'types' => ['diet'],
                'categories' => ['drinks'],
                'image_path' => 'images/meals/drinks/red-fruit-mix.png',
                'price' => 70000,
            ],
            [
                'title' => 'اسموتی بهشتی',
                'slug' => 'paradise-smoothie',
                'calories' => 150,
                'nutritional_informations' => [
                    'انرژی' => '150 کیلوکالری',
                    'کربوهیدرات' => '35 گرم',
                    'پروتئین' => '2 گرم',
                    'چربی' => '0.3 گرم'
                ],
                'ingredients' => ['سیب', 'نعناع', 'زنجبیل', 'لیمو', 'عسل', 'خیار', 'آب'],
                'consumable_items' => [
                    'تعادل فوق‌العاده‌ای از طعم‌ها',
                    'سم‌زدایی و هیدراتاسیون عالی',
                    'تقویت سیستم ایمنی',
                    'دارای فیبر بالا و کمک به کاهش نفخ',
                    'کمک به کاهش وزن'
                ],
                'contraindications' => [
                    'افرادیکه به زنجبیل آلرژی دارند و افراد دیابتی با احتیاط مصرف شود'
                ],
                'types' => ['diet'],
                'categories' => ['drinks'],
                'image_path' => null,
                'price' => 180000,
            ],
            [
                'title' => 'نوشیدنی بیدمشک',
                'slug' => 'elderflower-drink',
                'calories' => 50,
                'nutritional_informations' => [
                    'انرژی' => '50 کیلوکالری',
                    'کربوهیدرات' => '12 گرم',
                    'پروتئین' => '0.5 گرم',
                    'چربی' => '0 گرم'
                ],
                'ingredients' => ['بیدمشک', 'آب', 'شکر'],
                'consumable_items' => [
                    'خاصیت آرامبخش',
                    'کم‌کالری و رفع عطش'
                ],
                'contraindications' => [
                    'در صورت حساسیت غذایی با احتیاط مصرف شود'
                ],
                'types' => ['diet'],
                'categories' => ['drinks'],
                'image_path' => 'images/meals/drinks/elderflower-drink.png',
                'price' => 50000,
            ],
            [
                'title' => 'نوشیدنی بهار نارنج',
                'slug' => 'bitter-orange-drink',
                'calories' => 55,
                'nutritional_informations' => [
                    'انرژی' => '55 کیلوکالری',
                    'کربوهیدرات' => '13 گرم',
                    'پروتئین' => '0.5 گرم',
                    'چربی' => '0 گرم'
                ],
                'ingredients' => ['بهار نارنج', 'آب', 'شکر'],
                'consumable_items' => [
                    'خاصیت آرامبخش و خواب‌آور',
                    'کم‌کالری'
                ],
                'contraindications' => [
                    'در صورت حساسیت غذایی با احتیاط مصرف شود'
                ],
                'types' => ['diet'],
                'categories' => ['drinks'],
                'image_path' => 'images/meals/drinks/bitter-orange-drink.png',
                'price' => 50000,
            ],
            [
                'title' => ' موهیتو ',
                'slug' => 'mohito',
                'calories' => 90,
                'nutritional_informations' => [
                    'انرژی' => '90 کیلوکالری',
                    'کربوهیدرات' => '22 گرم',
                    'پروتئین' => '0.5 گرم',
                    'چربی' => '0 گرم'
                ],
                'ingredients' => ['نعناع', 'آب لیمو', 'آب', 'شکر'],
                'consumable_items' => [
                    'رفع عطش و تازگی',
                    'کم‌کالری و خوشمزه'
                ],
                'contraindications' => [
                    'در صورت حساسیت غذایی با احتیاط مصرف شود'
                ],
                'types' => ['diet'],
                'categories' => ['drinks'],
                'image_path' => 'images/meals/drinks/mohito.png',
                'price' => 60000,
            ],
             [
                 'title' => 'نوشیدنی آرامش',
                 'slug' => 'calm-drink',
                 'calories' => 40,
                 'nutritional_informations' => [
                     'انرژی' => '40 کیلوکالری',
                     'کربوهیدرات' => '3.5 گرم',
                     'پروتئین' => '2 گرم',
                     'چربی' => '2 گرم'
                 ],
                 'ingredients' => ['عرق بیدمشک', 'تخم شربتی', 'دانه چیا', 'آب آشامیدنی', 'شیرین کننده رژیمی'],
                 'consumable_items' => [
                     'فیبر بسیار بالا (نسبت به کالری)',
                     'منبع عالی امگا-۳ گیاهی',
                     'هیدراتاسیون عالی با آزادسازی تدریجی آب',
                     'بدون قند و کم کالری'
                 ],
                 'contraindications' => [
                     'مصرف با داروهای رقیق‌کننده خون با احتیاط (به دلیل امگا-۳) انجام شود'
                 ],
                 'types' => ['diet'],
                 'categories' => ['drinks'],
                 'image_path' => null,
                 'price' => 50000,
             ],
        ];

        // Preload or create related types and category
        $typeModels = collect(['light', 'energy', 'diet'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['drinks'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه نوشیدنی‌های سالم و تازه ایوا.',
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
                                ->cover(600, 800)
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