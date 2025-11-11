<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Image as ImageModel;
use App\Models\Ingredient;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class BreakfastMealSeeder extends Seeder
{
    public function run(): void
    {
        // Prevent memory issues during thumbnail creation
        @ini_set('memory_limit', '512M');

        $defaultImagePath = 'images/default-meals-images/breakfast.jpg';

        // Ensure thumbnails directory exists
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        $meals = [
            [
                'title' => 'بریتیش',
                'slug' => 'british',
                'calories' => 500,
                'price' => 250000,
                'nutritional_informations' => [
                    'کربوهیدرات' => '58 گرم',
                    'پروتئین' => '28 گرم',
                    'چربی' => '18 گرم',
                ],
                'ingredients' => [
                    'نان تست بهمراه پنیر فتا و گردو',
                    'لوبیا پخته',
                    'تخم مرغ آب پز',
                    'نوشیدنی تخم شربتی'
                ],
                'consumable_items' => [
                    'یک میان وعده مقوی و کامل و سبک',
                    'منبع عالی از پروتئین حیوانی و گیاهی با آمینو اسیدهای ضروری بدن',
                    'دارای چربیهای سالم از گردو و  زرده تخم مرغ',
                    'دارای کلسیم',
                    'تعادل کامل درشت‌مغذی‌ها',
                    'منبع عالی فیبر و اسیدهای چرب امگا۳',
                    'منبع ویتامین‌ها و مواد معدنی متنوع',
                    'ایجاد حس سیری و هضم آهسته تر قندها و آبرسانی ',
                    'مناسب برای کنترل وزن (در اندازه متعادل)'
                ],
                'contraindications' => [
                    'در افراد آلرژی به تخم مرغ',
                    'عدم تحمل لاکتوز (شیر و پنیر)',
                    'حساسیت به مغزها (گردو)',
                    'حساسیت به گلوتن (نان تست)',
                    'نقرس حاد (به دلیل پورین در لوبیا)',
                    'بیماری کلیوی پیشرفته (پروتئین بالا)',
                    'فنیل کتونوری (PKU)',
                ],
                'types' => ['diet'],
                'categories' => ['breakfast'],
                'image_path' => 'images/meals/breakfast/british.png',
            ],
            [
                'title' => 'پک پنکیک بار',
                'slug' => 'pancake-bar-pack',
                'calories' => 800,
                'price' => 230000,
                'nutritional_informations' => [
                    'کربوهیدرات' => '95 گرم',
                    'پروتئین' => '32 گرم',
                    'چربی' => '33 گرم',
                ],
                'ingredients' => [
                    'دو عدد پنکیک اوتمیل',
                    'ساشه عسل',
                    'نوشیدنی کافی میلک',
                    'یک عدد میکس نوت بار با سس ارده (گردو، بادام‌زمینی، پرک جودوسر، کشمش، خرما، ارده)',
                ],
                'consumable_items' => [
                    'انرژی پایدار تا ساعتها',
                    'مقوی برای مغز و حافظه',
                    'مناسب ورزشکاران',
                    'منبع عالی فیبر',
                    'منبع عالی از امگا۳ و ویتامین E و چربی‌های سالم',
                    'دارای آهن و کلسیم',
                ],
                'contraindications' => [
                    'افرادی که رژیم گلوتن فری دارند',
                    'افراد دیابتی',
                    'افرادی که آلرژی به دانه‌های روغنی دارند',
                ],
                'types' => ['diet'],
                'categories' => ['breakfast'],
                'image_path' => 'images/meals/breakfast/pancake-bar-pack.png',
            ],
            [
                'title' => 'کرپ تخم مرغ و سبزیجات',
                'slug' => 'egg-veggie-crepe',
                'calories' => 440,
                'price' => 225000,
                'nutritional_informations' => [
                    'کربوهیدرات' => '56 گرم',
                    'پروتئین' => '22 گرم',
                    'چربی' => '14 گرم',
                ],
                'ingredients' => [
                    'تخم مرغ',
                    'فلفل دلمه رنگی',
                    'بروکلی',
                    'جعفری',
                    'هویج',
                    'کدو',
                    'نوشیدنی پرتقال',
                    'پوره سیب زمینی',
                    'نان تست مزه دار شده',
                ],
                'consumable_items' => [
                    'دارای ویتامین‌های A، B12، C.',
                    'مناسب برای سلامت مغز و چشم.',
                    'سرشار از فیبر و آنتی اکسیدان.',
                    'تامین انرژی پایدار و منبع خوبی از پتاسیم.',
                ],
                'contraindications' => [
                    'افراد دیابتی در مصرف آن احتیاط کنند.',
                    'در رژیم‌های گلوتن فری به‌واسطه نان تست مصرف نشود.',
                ],
                'types' => ['diet'],
                'categories' => ['breakfast'],
                'image_path' => null,
            ],
            [
                'title' => 'موراکو فروت',
                'slug' => 'morocco-fruit',
                'calories' => 500,
                'price' => 225000,
                'nutritional_informations' => [
                    'کربوهیدرات' => '65 گرم',
                    'پروتئین' => '20 گرم',
                    'چربی' => '19 گرم',
                ],
                'ingredients' => [
                    'نان تست',
                    'کره بادام زمینی',
                    'نوشیدنی کافی میلک',
                    'سالاد میوه',
                ],
                'consumable_items' => [
                    'تعادل کامل درشت‌مغذی‌ها: پروتئین (تست)، چربی سالم (کره بادام)، کربوهیدرات (میوه و نان).',
                    'انرژی پایدار تا ساعت‌ها با ترکیب کافئین، فیبر و چربی سالم.',
                    'افزایش مقاومت در برابر هوس‌های غذایی و ایجاد حس سیری طولانی.',
                    'تأمین ریزمغذی‌ها و تقویت سیستم ایمنی: ویتامین C (سالاد میوه) + روی (بادام زمینی).',
                    'بهبود عملکرد مغز با کافئین، امگا۳ و آنتی‌اکسیدان‌ها.',
                    'سرشار از ویتامین‌ها، آبرسان و شاداب‌کننده پوست.',
                ],
                'contraindications' => [
                    'افراد دارای آلرژی به بادام زمینی.',
                    'افراد با عدم تحمل لاکتوز.',
                    'افراد حساس به کافئین.',
                    'افراد با حساسیت به گلوتن.',
                    'افراد دارای دیابت کنترل‌نشده یا مشکلات گوارشی.',
                ],
                'types' => ['energy'],
                'categories' => ['breakfast'],
                'image_path' => 'images/meals/breakfast/morocco-fruit.png',
            ],
        ];

        $typeModels = collect(['energy', 'diet', 'light'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['breakfast'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه صبحانه‌های سالم و انرژی زا ایوا.',
                'calories' => $data['calories'],
                'price' => $data['price'] ?? 170000,
                'is_vegan' => false,
                'kcal' => $data['calories'],
                'nutritional_informations' => $data['nutritional_informations'],
                'consumable_items' => $data['consumable_items'],
                'contraindications' => $data['contraindications'],
            ]);

            // Attach ingredients
            $ingredientIds = collect($data['ingredients'])->map(
                fn($title) =>
                Ingredient::firstOrCreate(['title' => $title])->id
            );
            $meal->ingredients()->sync($ingredientIds);

            // Attach category and type
            $meal->categories()->sync(
                collect($data['categories'])->map(fn($c) => $categoryModels[$c]->id)
            );
            $meal->types()->sync(
                collect($data['types'])->map(fn($t) => $typeModels[$t]->id)
            );

            // Prepare image and generate thumbnail
            $imagePath = $data['image_path'] ?? $defaultImagePath;
            $fullImagePath = public_path($imagePath);
            $thumbnailUrl = null;

            if (File::exists($fullImagePath)) {
                $filename = pathinfo($imagePath, PATHINFO_BASENAME);
                $thumbnailPath = $thumbDir . '/' . $filename;

                if (File::exists($thumbnailPath)) {
                    $thumbnailUrl = 'images/thumbnails/' . $filename;
                } else {
                    $fileSize = File::size($fullImagePath);
                    if ($fileSize <= 20 * 1024 * 1024) {
                        try {
                            Image::read($fullImagePath)
                                ->cover(600, 400)
                                ->save($thumbnailPath);

                            $thumbnailUrl = 'images/thumbnails/' . $filename;
                        } catch (\Throwable $e) {
                            // Ignore image processing errors
                        }
                    }
                }
            }

            // Create or update Image model
            $image = ImageModel::updateOrCreate(
                ['url' => $imagePath],
                ['thumbnail_url' => $thumbnailUrl]
            );

            $meal->images()->syncWithoutDetaching([$image->id]);
        }
    }
}
