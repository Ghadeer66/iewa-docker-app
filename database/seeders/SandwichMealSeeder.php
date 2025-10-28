<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Image;
use App\Models\Ingredient;

class SandwichMealSeeder extends Seeder
{
    public function run(): void
    {
        $defaultImagePath = 'images/default-meals-images/sandwich.jpg';

        $meals = [
            [
                'title' => 'ساندویچ مرغ پستو',
                'slug' => 'chicken-pesto-sandwich',
                'calories' => 340,
                'nutritional_informations' => [
                    'پروتئین' => '30 گرم',
                    'کربوهیدرات' => '40 گرم',
                    'چربی' => '6 گرم',
                ],
                'ingredients' => ['فیله مرغ', 'گوجه چری', 'ریحون', 'نان', 'کاهو', 'سس پستو'],
                'consumable_items' => [
                    'یک وعده غذایی سالم و سبک که انرژی مورد نیاز بدن را تامین می‌کند و به عضله‌سازی کمک می‌کند.',
                ],
                'contraindications' => [
                    'در رژیم‌های گلوتن فری و بیماران سلیاکی توصیه نمی‌شود.',
                ],
                'types' => ['light'],
                'categories' => ['sandwich'],
                'image_path' => null,
            ],
            [
                'title' => 'گرین ساندویچ',
                'slug' => 'green-sandwich',
                'calories' => 410,
                'nutritional_informations' => [
                    'پروتئین' => '38 گرم',
                    'کربوهیدرات' => '35 گرم',
                    'چربی' => '13 گرم',
                ],
                'ingredients' => ['نان', 'فیله مرغ', 'دیپ فلفل دلمه', 'زیتون سبز', 'کاهو'],
                'consumable_items' => [
                    'منبع مناسبی از پروتئین و برای عضله‌سازی مناسب است.',
                    'همچنین سرشار از کلسیم می‌باشد.',
                ],
                'contraindications' => [
                    'در رژیم‌های گلوتن فری توصیه نمی‌شود.',
                ],
                'types' => ['energy'],
                'categories' => ['sandwich'],
                'image_path' => null,
            ],
            [
                'title' => 'چیز تست',
                'slug' => 'cheese-toast',
                'calories' => 295,
                'nutritional_informations' => [
                    'پروتئین' => '16 گرم',
                    'کربوهیدرات' => '35 گرم',
                    'چربی' => '10 گرم',
                ],
                'ingredients' => ['نان تست هفت غله', 'پنیر فتا کم چرب', 'زیتون', 'ریحون', 'گوجه خشک', 'بادام زمینی'],
                'consumable_items' => [
                    'برای افراد دارای رژیم وگان مناسب است.',
                    'بدلیل وجود بادام‌زمینی و زیتون منبع مناسبی از چربی‌های مفید می‌باشد.',
                    'بعنوان یک وعده غذایی سالم و سبک قابل استفاده است.',
                ],
                'contraindications' => [
                    'جهت افرادیکه به دانه‌های روغنی آلرژی دارند توصیه نمی‌شود.',
                    'در رژیم‌های گلوتن فری قابل استفاده نیست.',
                ],
                'types' => ['light'],
                'categories' => ['sandwich'],
                'image_path' => null,
            ],
            [
                'title' => 'چیزساندویچ',
                'slug' => 'cheese-sandwich',
                'calories' => 430,
                'nutritional_informations' => [
                    'پروتئین' => '35 گرم',
                    'کربوهیدرات' => '40 گرم',
                    'چربی' => '15 گرم',
                ],
                'ingredients' => ['نان چاپاتا', 'پنیر ورقه‌ای', 'مرغ', 'گوجه خشک', 'کنجد', 'کاهو'],
                'consumable_items' => [
                    'منبع مناسبی از پروتئین و جهت عضله‌سازی موثر است.',
                    'بدلیل وجود کنجد منبع مناسبی از چربی مفید و بدون کلسترول می‌باشد.',
                ],
                'contraindications' => [
                    'در رژیم‌های کم‌کربوهیدرات، گلوتن فری و بیماران سلیاکی توصیه نمی‌شود.',
                ],
                'types' => ['diet'],
                'categories' => ['sandwich'],
                'image_path' => null,
            ],
        ];

        // Preload or create related types and category
        $typeModels = collect(['light', 'energy', 'diet'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['sandwich'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه ساندویچ‌های سالم و سبک ایوا.',
                'calories' => $data['calories'],
                'price' => 190000,
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

            // Attach image (default if not provided)
            $imagePath = $data['image_path'] ?? $defaultImagePath;
            $image = Image::firstOrCreate(['url' => $imagePath]);
            $meal->images()->syncWithoutDetaching([$image->id]);
        }
    }
}
