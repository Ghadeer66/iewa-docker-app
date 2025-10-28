<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Image;
use App\Models\Ingredient;

class BreakfastMealSeeder extends Seeder
{
    public function run(): void
    {
        $defaultImagePath = 'images/default-meals-images/breakfast.jpg';

        $meals = [
            [
                'title' => 'تست فرانسوی',
                'slug' => 'french-toast',
                'calories' => 465,
                'nutritional_informations' => [
                    'کربوهیدرات' => '43 گرم',
                    'پروتئین' => '26 گرم',
                    'چربی' => '21 گرم',
                ],
                'ingredients' => ['دو عدد نان تست', 'تخم مرغ', 'کنجد', 'عسل ساشه ای'],
                'consumable_items' => [
                    'یک صبحانه قوی و انرژیک که برای مدتها شما را سیر نگه می‌دارد.',
                    'بدلیل وجود تخم مرغ منبع عالی از پروتئین و ویتامین D و آنتی اکسیدان‌های قوی است.',
                    'تقویت سلامت مغز، حافظه، چشم‌ها، پوست و مو را فراهم می‌کند.',
                ],
                'contraindications' => [
                    'در رژیم های کم کربوهیدرات و گلوتن فری توصیه نمی‌شود.',
                    'افراد با شرایط پزشکی خاص (مانند دیابت کنترل نشده یا کلسترول بسیار بالا) باید طبق دستور پزشک خود مصرف کنند.',
                ],
                'types' => ['energy'],
                'categories' => ['breakfast'],
                'image_path' => null,
            ],
            [
                'title' => 'چیاتست',
                'slug' => 'chia-toast',
                'calories' => 290,
                'nutritional_informations' => [
                    'کربوهیدرات' => '40 گرم',
                    'پروتئین' => '11 گرم',
                    'چربی' => '10 گرم',
                ],
                'ingredients' => ['نان تست سبوس دار', 'پنیرفتا کم چرب', 'خرما', 'گردو دانه چیا'],
                'consumable_items' => [
                    'یک صبحانه ایده آل و مقوی است که بدلیل حضور گردو و دانه چیا سرشار از امگا۳ و چربیهای غیراشباع می‌باشد که باعث سلامت قلب و مغز و کاهش التهاب میشود.',
                    'باعث تعادل بهتر قند خون و جذب ویتامین‌های محلول در چربی میگردد همچنین با بخاطر فیبر بالا در این وعده به تنظیم حرکات روده و پیشگیری از یبوست کمک می‌کند.',
                    'پنیر  و کنجد هم منبع بسیار خوبی از کلسیم و فسفرهستند',
                ],
                'contraindications' => [
                    'افرادیکه مشکلات دیابتی دارند و افراد مستعد به سنگ کلیه اگزالاتی  و آلرژی به دانه های روغنی توصیه نمیشود.',
                    'در رژیم‌های کم کربوهیدرات  و رژیمهای کتوژنیک و گلوتن فری قابل استفاده نیست'
                ],
                'types' => ['light'],
                'categories' => ['breakfast'],
                'image_path' => null,
            ],
            [
                'title' => 'پینات تست',
                'slug' => 'peanut-toast',
                'calories' => 460,
                'nutritional_informations' => [
                    'کربوهیدرات' => '42 گرم',
                    'پروتئین' => '16 گرم',
                    'چربی' => '27 گرم',
                ],
                'ingredients' => ['دو عدد نان تست', 'کره بادام زمینی', 'دانه چیا'],
                'consumable_items' => [
                    'انرژی را به تدریج در بدن آزاد می‌کند و برای ساعت‌ها شما را سیر و پرانرژی نگه می‌دارد.',
                    'بدلیل وجود دانه چیا سرشار از فیبر، اسیدهای چرب امگا-۳ و ریزمغذی‌ها است.',
                    'انتخاب عالی برای روزهای پرمشغله یا قبل از فعالیت ورزشی.',
                ],
                'contraindications' => [
                    'افراد دارای آلرژی به گلوتن و بادام زمینی توصیه نمی‌شود.',
                    'افراد دارای مشکلات گوارشی خاص مثل IBS یا سوءهاضمه توصیه نمی‌شود.',
                    'افراد در حال کاهش وزن و رژیم کم کالری با احتیاط مصرف کنند.',
                    'افراد دارای بیماری کلیوی خاص توصیه نمی‌شود.',
                ],
                'types' => ['energy'],
                'categories' => ['breakfast'],
                'image_path' => null,
            ],
            [
                'title' => 'چیز تست ارده‌ای',
                'slug' => 'tahini-cheese-toast',
                'calories' => 420,
                'nutritional_informations' => [
                    'کربوهیدرات' => '55 گرم',
                    'پروتئین' => '15 گرم',
                    'چربی' => '16 گرم',
                ],
                'ingredients' => ['نان تست سبوس دار', 'پنیر فتا کم چرب', 'ارده', 'موز'],
                'consumable_items' => [
                    'نان سبوس‌دار و موز سرشار از فیبر هستند و به بهبود دستگاه گوارش کمک می‌کنند.',
                    'ارده و پنیر منبع بسیار خوبی از کلسیم هستند.',
                    'ارده سرشار از اسیدهای چرب غیراشباع و فیتوسترول‌هاست و به حفظ سلامت قلب کمک می‌کند.',
                ],
                'contraindications' => [
                    'افراد دارای حساسیت‌های غذایی، IBS و رژیم‌های گلوتن فری مصرف نکنند.',
                ],
                'types' => ['energy'],
                'categories' => ['breakfast'],
                'image_path' => null,
            ],
            [
                'title' => 'اگ تست مدیترانه‌ای',
                'slug' => 'mediterranean-egg-toast',
                'calories' => 305,
                'nutritional_informations' => [
                    'کربوهیدرات' => '35 گرم',
                    'پروتئین' => '14 گرم',
                    'چربی' => '12 گرم',
                ],
                'ingredients' => ['نان تست', 'تخم مرغ', 'زیتون', 'ریحون', 'پنیر پارمسان'],
                'consumable_items' => [
                    'انتخاب مناسب برای کاهش وزن و صبحانه سبک.',
                    'دارای چربی‌های مفید غیر اشباع و پروتئین باکیفیت برای سیری طولانی‌مدت.',
                    'سرشار از کلسیم و فسفر.',
                ],
                'contraindications' => [
                    'افراد دارای حساسیت به لبنیات، لاکتوز، تخم مرغ و بیماران سلیاکی مصرف نکنند.',
                ],
                'types' => ['diet'],
                'categories' => ['breakfast'],
                'image_path' => null,
            ],
        ];

        // Preload or create types and category
        $typeModels = collect(['energy', 'diet','light'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);
        $categoryModels = collect(['breakfast'])
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

            // Attach image (default if not provided)
            $imagePath = $data['image_path'] ?? $defaultImagePath;
            $image = Image::firstOrCreate(['url' => $imagePath]);
            $meal->images()->syncWithoutDetaching([$image->id]);
        }
    }
}
