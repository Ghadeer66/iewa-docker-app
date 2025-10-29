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

class PackageMealSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory limit for image processing during seeding
        @ini_set('memory_limit', '512M');

        $defaultImagePath = 'images/default-meals-images/package.jpg';

        // define where thumbnails go
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        $meals = [
            [
                'title' => '24F',
                'slug' => 'potato-chicken-cheese-dent-chocolate',
                'calories' => 450,
                'nutritional_informations' => ['کربوهیدرات' => '49 گرم', 'پروتئین' => '30 گرم', 'چربی' => '15 گرم'],
                'ingredients' => ['تخم‌مرغ', 'مرغ', 'پنیر ورقه‌ای', 'دسر دنت شکلاتی'],
                'consumable_items' => [
                    'تخم‌مرغ و مرغ حاوی پروتئین کامل با کیفیت بالا هستند که برای ساخت و ترمیم عضلات، سلامت پوست و مو و تقویت سیستم ایمنی ضروری است.',
                    'پودر کاکائو حاوی ترکیباتی مانند تئوبرومین و فلاونوئیدها است که می‌توانند خلق و خو را بهبود بخشند و دارای خاصیت آنتی‌اکسیدانی هستند.',
                    'ورزشکارانی که به دنبال یک ریکاوری مقوی اما کم‌چرب هستند.',
                ],
                'contraindications' => ['در افراد دارای آلرژی به تخم مرغ، عدم تحمل لاکتوز، بیماران دیابتی کنترل نشده و مبتلایان به نقرس حاد مصرف نشود.'],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/24f.png'
            ],
            [
                'title' => '12F',
                'slug' => 'potato-chicken-red-fruit-dent-chocolate',
                'calories' => 560,
                'nutritional_informations' => ['کربوهیدرات' => '77 گرم', 'پروتئین' => '30 گرم', 'چربی' => '14 گرم'],
                'ingredients' => ['تخم‌مرغ', 'مرغ', 'نوشیدنی میوه های سرخ', 'دسر دنت شکلاتی'],
                'consumable_items' => [
                    'پروتئین کامل مرغ و تخم‌مرغ برای ساخت و ترمیم عضلات و تقویت سیستم ایمنی.',
                    'نوشیدنی میوه حاوی آنتی‌اکسیدان و ویتامین C و آنتوسیانین.',
                    'تخم‌مرغ منبع خوب ویتامین D و مرغ حاوی فسفر است.',
                ],
                'contraindications' => [
                    'مصرف همزمان مرغ و تخم‌مرغ برای افرادی که به پورین حساسیت دارند یا دچار نقرس هستند توصیه نمی‌شود.',
                    'افراد حساس به تخم مرغ یا گلوتن مصرف نکنند.',
                ],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/12f.png'
            ],
            [
                'title' => '13F',
                'slug' => 'ciabatta-chicken-cheese-orange-coffee-dent',
                'calories' => 580,
                'nutritional_informations' => ['کربوهیدرات' => '70 گرم', 'پروتئین' => '48 گرم', 'چربی' => '11.5 گرم'],
                'ingredients' => ['نان چاپاتا', 'مرغ', 'پنیر', 'نوشیدنی پرتقال', 'دسر دنت قهوه'],
                'consumable_items' => [
                    'کربوهیدرات‌های نان چاپاتی همراه با پروتئین بالای مرغ از نوسانات قند خون جلوگیری می‌کنند.',
                    'نوشیدنی پرتقال طبیعی منبع عالی ویتامین C است.',
                ],
                'contraindications' => ['افراد حساس به گلوتن و کافئین مصرف نکنند.'],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/13f.png'
            ],
            [
                'title' => '14F',
                'slug' => 'ciabatta-chicken-cheese-cool-coffee-fruit-dent',
                'calories' => 490,
                'nutritional_informations' => ['کربوهیدرات' => '50 گرم', 'پروتئین' => '46 گرم', 'چربی' => '12.5 گرم'],
                'ingredients' => ['نان چاپاتا', 'مرغ', 'پنیر', 'نوشیدنی کول کافی', 'دسر دنت میوه‌ای'],
                'consumable_items' => [
                    'بعلت حضور مرغ و پنیر یک میان وعده عالی سرشار از پروتیین و کم چربی است.',
                    'دارای ویتامین دی و کلسیم می‌باشد. نقطه قوت اصلی این میان‌وعده این است که برای سیری طولانی‌مدت، عضله‌سازی و ریکاوری عالی است.'
                ],
                'contraindications' => [
                    'برای افراد گلوتن فری و حساس به لاکتوز و آلرژن به کافئین توصیه نمی‌شود.'
                ],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/15fn.png'
            ],
            [
                'title' => '15F',
                'slug' => '15f',
                'calories' => 312,
                'nutritional_informations' => ['کربوهیدرات' => '50 گرم', 'پروتئین' => '10 گرم', 'چربی' => '8 گرم'],
                'ingredients' => ['کیک کشمشی', 'نوشیدنی چیلی کافی', 'دسر ماست میوه‌ای'],
                'consumable_items' => ['این میان‌وعده برای زمانی که فعالیت فکری یا جسمی دارید، مناسبه! ماست میوه‌ای ترکیبی از کلسیم و ویتامین D و ویتامین‌ها می‌باشد.'],
                'contraindications' => ['افراد دیابتی و گلوتن فری و حساس به لاکتوز مصرف نکنند.'],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/15f.png'
            ],
            [
                'title' => '23F',
                'slug' => '23f',
                'calories' => 260,
                'nutritional_informations' => ['کربوهیدرات' => '28 گرم', 'پروتئین' => '10.5 گرم', 'چربی' => '12 گرم'],
                'ingredients' => ['حمص', 'چوبک شویدی', 'نوشیدنی بیدمشک'],
                'consumable_items' => [
                    'پروتئین مناسب از حمص، دارای چربی‌های سالم از ارده و روغن زیتون در حمص.',
                    'فیبر بالا برای هضم بهتر و انرژی پایدار بدون افت قند.',
                ],
                'contraindications' => [
                    'افراد دارای مشکلات گوارشی و حساس به حبوبات و سندروم روده تحریک پذیر و آلرژن به کنجد با احتیاط مصرف شود.'
                ],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/23f.png'
            ],
            [
                'title' => '22FN',
                'slug' => '22fn',
                'calories' => 485,
                'nutritional_informations' => ['کربوهیدرات' => '47 گرم', 'پروتئین' => '14 گرم', 'چربی' => '27 گرم'],
                'ingredients' => ['دیپ پنیر و زیتون', 'چوبک شویدی', 'نوشیدنی پرتقال'],
                'consumable_items' => [
                    'برای افرادی که وقت کافی برای تهیه صبحانه مفصل ندارند، این ترکیب یک صبحانه کامل و سیرکننده است.',
                    'وجود پنیر منبع پروتئین و کلسیم و زیتون و شوید تامین فیبر و چربی غیر اشباع بدن را دارد.'
                ],
                'contraindications' => [
                    'افراد در معرض دیابت و فشار خون بالا و حساس به گلوتن مصرف نکنند.'
                ],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/22fn.png'
            ],
            [
                'title' => '33F',
                'slug' => '33f',
                'calories' => 250,
                'nutritional_informations' => ['کربوهیدرات' => '45 گرم', 'پروتئین' => '5 گرم', 'چربی' => '6 گرم'],
                'ingredients' => ['کیک سبوس دار', 'نوشیدنی پرتقال'],
                'consumable_items' => ['این پک انتخاب کاملاً متعادل از نظر انرژی برای میان‌وعده است.'],
                'contraindications' => ['افراد دیابتی یا کسانی که مقاومت به انسولین دارند، با احتیاط مصرف کنند.'],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/33f.png'
            ],
            [
                'title' => '21F',
                'slug' => '21f',
                'calories' => 550,
                'nutritional_informations' => ['کربوهیدرات' => '85 گرم', 'پروتئین' => '20 گرم', 'چربی' => '15 گرم'],
                'ingredients' => ['نان اچمامغزدار', 'کول کافی', 'دسر میوه ای'],
                'consumable_items' => [
                    'خرما و گردو سرشار از مواد معدنی و ویتامین و آنتی‌اکسیدان‌ها و انرژی فوری برای مغز و قلب.',
                ],
                'contraindications' => [
                    'افراد گلوتن فری، حساس به لاکتوز و کافئین و افراد دیابتی مصرف ننمایند.'
                ],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/21f.png'
            ],
            [
                'title' => '39F',
                'slug' => '39f',
                'calories' => 450,
                'nutritional_informations' => ['کربوهیدرات' => '74 گرم', 'پروتئین' => '18 گرم', 'چربی' => '10 گرم'],
                'ingredients' => ['نان اچمامغزدار', 'کول کافی'],
                'consumable_items' => [
                    'خرما و گردو سرشار از مواد معدنی و ویتامین و آنتی‌اکسیدان‌ها و انرژی فوری برای مغز و قلب.',
                ],
                'contraindications' => [
                    'افراد گلوتن فری، حساس به لاکتوز و کافئین و افراد دارای اختلالات خواب و دیابتی مصرف ننمایند.'
                ],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/39f.png'
            ],
            [
                'title' => '31F',
                'slug' => '31f',
                'calories' => 465,
                'nutritional_informations' => ['کربوهیدرات' => '55 گرم', 'پروتئین' => '17 گرم', 'چربی' => '20 گرم'],
                'ingredients' => ['کیک لایه‌ای بادام زمینی', 'ارده', 'خرما', 'شکلات', 'نوشیدنی قهوه'],
                'consumable_items' => [
                    'بدلیل وجود ارده دارای چربی‌های مفید است که باعث بهبود عملکرد قلب و مغز میشود.'
                ],
                'contraindications' => [
                    'افراد گلوتن فری و آلرژن به بادام زمینی و افراد دیابتی مصرف نکنند.'
                ],
                'categories' => ['package'],
                'types' => ['energy'],
                'image_path' => 'images/meals/packages/31f.png'
            ],
        ];

        // Preload or create types and categories
        $typeModels = collect(['energy', 'diet', 'light'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['package'])
            ->mapWithKeys(fn($c) => [$c => Category::firstOrCreate(['title' => $c])]);

        foreach ($meals as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه صبحانه‌های سالم و انرژی زا ایوا.',
                'calories' => $data['calories'],
                'price' => 170000,
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
