<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Image as ImageModel;
use App\Models\Ingredient;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class EconomicMealSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory limit for image processing
        @ini_set('memory_limit', '512M');

        $defaultImagePath = 'images/default-meals-images/economic.jpg';

        // define where thumbnails will be stored
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        $meals = [
            [
                'title' => 'چیکنوا',
                'slug' => 'chickenoa',
                'calories' => 380,
                'nutritional_informations' => [
                    'کربوهیدرات' => '45 گرم',
                    'پروتئین' => '28 گرم',
                    'چربی' => '9.5 گرم',
                ],
                'ingredients' => ['سینه مرغ', 'کینوا', 'هویج', 'پیاز', 'فلفل دلمه سبز'],
                'consumable_items' => [
                    'بدلیل وجود هویج و وجود پیش سازهای ویتامین آ در بهبود بینایی موثر است.',
                    'بدلیل وجود کینوا دارای خاصیت ضد التهابی و آنتی اکسیدانی و ضد سرطانی می‌باشد.',
                    'همچنین بدلیل فیبر بالا برای رفع یبوست موثر است.',
                ],
                'contraindications' => [
                    'در افرادی که دارای سنگ کلیه اگزالاتی هستند بهتر است با احتیاط مصرف شود.',
                ],
                'types' => ['light'],
                'categories' => ['economic'],
                'image_path' => 'images/meals/economic/chickenoa.png',
            ],
            [
                'title' => 'چیکی یاتوری',
                'slug' => 'chicky-yatori',
                'calories' => 495,
                'nutritional_informations' => [
                    'کربوهیدرات' => '80 گرم',
                    'پروتئین' => '26 گرم',
                    'چربی' => '7.5 گرم',
                ],
                'ingredients' => ['برنج قهوه‌ای', 'مرغ', 'گوجه خشک', 'هویج', 'پیاز', 'فلفل دلمه‌ای'],
                'consumable_items' => [
                    'بدلیل وجود رنگدانه لیکوپن دارای خاصیت آنتی اکسیدانی می‌باشد.',
                    'برنج قهوه ای دارای فیبر بالاتر می‌باشد و در بهبود یبوست موثر است.',
                ],
                'contraindications' => [
                    'بدلیل وجود پودر سیر و پیاز برای مادران شیرده توصیه نمی‌شود.',
                    'در رژیم کتوژنیک قابل استفاده نیست.',
                ],
                'types' => ['diet'],
                'categories' => ['economic'],
                'image_path' => 'images/meals/economic/chicky-yatori.png',
            ],
            [
                'title' => 'میت اسپاگیتو',
                'slug' => 'meat-spagheto',
                'calories' => 350,
                'nutritional_informations' => [
                    'کربوهیدرات' => '48 گرم',
                    'پروتئین' => '25 گرم',
                    'چربی' => '7 گرم',
                ],
                'ingredients' => ['اسپاگتی', 'گوشت چرخ شده', 'قارچ', 'پیاز', 'پنیر پارمسان', 'توماتو سس'],
                'consumable_items' => [
                    'منبع مناسب پروتئین و کربوهیدرات کافی می‌باشد.',
                    'بدلیل وجود پنیر منبع خوبی از کلسیم و پروتئین می‌باشد.',
                ],
                'contraindications' => ['بدلیل وجود پیاز برای مادران شیرده توصیه نمیشود.'],
                'types' => ['energy'],
                'categories' => ['economic'],
                'image_path' => 'images/meals/economic/meat-spagheto.png',
            ],
            [
                'title' => 'مرغ و بادمجان',
                'slug' => 'chicken-eggplant',
                'calories' => 410,
                'nutritional_informations' => [
                    'کربوهیدرات' => '69 گرم',
                    'پروتئین' => '25 گرم',
                    'چربی' => '4.5 گرم',
                ],
                'ingredients' => ['برنج قهوه ای', 'سینه مرغ', 'گوجه', 'بادمجان', 'توماتو سس'],
                'consumable_items' => [
                    'بدلیل وجود رنگدانه های لیکوپن دارای خاصیت ضد سرطانی و آنتی اکسیدانی می‌باشد.',
                ],
                'contraindications' => ['قابل استفاده در رژیم کتوژنیک نیست.'],
                'types' => ['energy'],
                'categories' => ['economic'],
                'image_path' => 'images/meals/economic/chicken-eggplant.png',
            ],
            [
                'title' => 'چیکن وجتبل',
                'slug' => 'chicken-vegetable',
                'calories' => 226,
                'nutritional_informations' => [
                    'کربوهیدرات' => '20 گرم',
                    'پروتئین' => '23 گرم',
                    'چربی' => '6 گرم',
                ],
                'ingredients' => ['بادمجان کبابی'],
                'consumable_items' => [
                    'بعنوان یک غذای سبک و کم کالری و افرادیکه در رژیم کاهش وزن هستند و ورزشکاران انتخاب مناسبی می‌باشد.',
                ],
                'contraindications' => ['ندارد'],
                'types' => ['diet'],
                'categories' => ['economic'],
                'image_path' => 'images/meals/economic/chicken-vegetable.png',
            ],
            [
                'title' => 'گریک رایس',
                'slug' => 'greek-rice',
                'calories' => 453,
                'nutritional_informations' => [
                    'کربوهیدرات' => '50 گرم',
                    'پروتئین' => '25 گرم',
                    'چربی' => '17 گرم',
                ],
                'ingredients' => ['سینه مرغ', 'برنج', 'خلال بادام', 'چیپس پسته', 'هویج', 'زرشک'],
                'consumable_items' => [
                    'بعنوان یک وعده غذای سالم و انرژیک قابل استفاده است.',
                    'دارای چربی‌های مفید و کاهنده چربی‌های مضر خون می‌باشد.',
                    'در بهبود بینایی موثر است.',
                ],
                'contraindications' => [
                    'برای افرادیکه به دانه های روغنی و مغزها آلرژی دارند توصیه نمی‌شود.',
                ],
                'types' => ['energy'],
                'categories' => ['economic'],
                'image_path' => 'images/meals/economic/greek-rice.png',
            ],
        ];

        // Preload or create types and categories
        $typeModels = collect(['light', 'diet', 'energy'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['economic'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'این غذای اکونومی از سری غذاهای سالم ایوا است.',
                'calories' => $data['calories'],
                'price' => 250000,
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

            // Image handling with thumbnail
            $imagePath = $data['image_path'] ?? $defaultImagePath;
            $fullImagePath = public_path($imagePath);
            $thumbnailUrl = null;

            if (File::exists($fullImagePath)) {
                $filename = pathinfo($imagePath, PATHINFO_BASENAME);
                $thumbnailPath = $thumbDir . '/' . $filename;

                if (File::exists($thumbnailPath)) {
                    $thumbnailUrl = 'images/thumbnails/' . $filename;
                } else {
                    $fileSizeBytes = File::size($fullImagePath);
                    if ($fileSizeBytes <= 20 * 1024 * 1024) { // skip >20MB
                        try {
                            $img = Image::read($fullImagePath)
                                ->cover(600, 400)
                                ->save($thumbnailPath);

                            $thumbnailUrl = 'images/thumbnails/' . $filename;
                        } catch (\Throwable $e) {
                            // Ignore image processing errors during seeding
                        }
                    }
                }
            }

            $image = ImageModel::firstOrCreate(
                ['url' => $imagePath],
                ['thumbnail_url' => $thumbnailUrl]
            );

            $meal->images()->syncWithoutDetaching([$image->id]);
        }
    }
}
