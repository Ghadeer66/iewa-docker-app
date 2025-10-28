<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Image;
use App\Models\Ingredient;

class EconomicMealSeeder extends Seeder
{
    public function run(): void
    {
        $defaultImagePath = 'images/default-meals-images/economic.jpg';

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
                'image_path' => null,
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
                'image_path' => null,
            ],
            [
                'title' => 'چیکن ماسان',
                'slug' => 'chicken-masan',
                'calories' => 335,
                'nutritional_informations' => [
                    'کربوهیدرات' => '50 گرم',
                    'پروتئین' => '24 گرم',
                    'چربی' => '4.5 گرم',
                ],
                'ingredients' => ['سینه مرغ', 'قارچ', 'برنج قهوه‌ای', 'فلفل دلمه رنگی', 'گوجه'],
                'consumable_items' => ['بعنوان یک غذای سالم و تامین کننده انرژی مورد نیاز بدن قابل استفاده است.'],
                'contraindications' => ['قابل استفاده در رژیم کتوژنیک نیست.'],
                'types' => ['energy'],
                'categories' => ['economic'],
                'image_path' => null,
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
                'image_path' => null,
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
                'image_path' => null,
            ],
            [
                'title' => 'چیکن رول (رول مغزدار مرغ)',
                'slug' => 'chicken-roll',
                'calories' => 270,
                'nutritional_informations' => [
                    'کربوهیدرات' => '13 گرم',
                    'پروتئین' => '34 گرم',
                    'چربی' => '10 گرم',
                ],
                'ingredients' => ['آرد گندم', 'تخم مرغ', 'مرغ', 'پودر پانکو'],
                'consumable_items' => ['بعنوان یک وعده غذای سالم و سبک قابل استفاده است.'],
                'contraindications' => ['در بیماران سلیاکی و رژیم‌های گلوتن فری قابل استفاده نیست.'],
                'types' => ['light'],
                'categories' => ['economic'],
                'image_path' => null,
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
                'ingredients' => [],
                'consumable_items' => [
                    'بعنوان یک غذای سبک و کم کالری و افرادیکه در رژیم کاهش وزن هستند و ورزشکاران انتخاب مناسبی می‌باشد.',
                ],
                'contraindications' => ['ندارد'],
                'types' => ['diet'],
                'categories' => ['economic'],
                'image_path' => null,
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
                'image_path' => null,
            ],
        ];

        // Pre-fetch or create types and categories
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
                'price' => 180000,
                'is_vegan' => false,
                'kcal' => $data['calories'],
                'nutritional_informations' => $data['nutritional_informations'],
                'consumable_items' => $data['consumable_items'],
                'contraindications' => $data['contraindications'],
            ]);

            // Attach ingredients (create if not exist)
            $ingredientIds = collect($data['ingredients'])->map(function ($title) {
                return Ingredient::firstOrCreate(['title' => $title])->id;
            });
            $meal->ingredients()->sync($ingredientIds);

            // Attach categories & types
            $meal->categories()->sync(
                collect($data['categories'])->map(fn($c) => $categoryModels[$c]->id)
            );
            $meal->types()->sync(
                collect($data['types'])->map(fn($t) => $typeModels[$t]->id)
            );

            // Handle image (use default if none provided)
            $imagePath = $data['image_path'] ?? $defaultImagePath;
            $image = Image::firstOrCreate(['url' => $imagePath]);
            $meal->images()->syncWithoutDetaching([$image->id]);
        }
    }
}
