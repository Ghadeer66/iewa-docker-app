<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Meal;
use App\Models\Image;
use App\Models\MealImage;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $now = Carbon::now();

    //     $meals = [
    //         [
    //             'title' => 'سالاد سبز ویژه',
    //             'slug' => 'salad',
    //             'description' => 'سالاد تازه با سبزیجات متنوع و سس مخصوص.',
    //             'price' => 85000,
    //             'kcal' => 220,
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //         ],
    //         [
    //             'title' => 'مرغ گریل رژیمی',
    //             'slug' => 'grilled_chicken',
    //             'description' => 'سینه مرغ گریل شده همراه با سبزیجات بخارپز.',
    //             'price' => 115000,
    //             'kcal' => 350,
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //         ],
    //         [
    //             'title' => 'پاستای سبزیجات',
    //             'slug' => 'veg_pasta',
    //             'description' => 'پاستا با سس سبک و سبزیجات تازه.',
    //             'price' => 95000,
    //             'kcal' => 410,
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //         ],
    //         [
    //             'title' => 'خوراک ماهی سالمون',
    //             'slug' => 'salmon',
    //             'description' => 'ماهی سالمون پخته شده با چاشنی لیمو و سبزیجات.',
    //             'price' => 175000,
    //             'kcal' => 420,
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //         ],
    //         [
    //             'title' => 'پکیج رژیمی روزانه',
    //             'slug' => 'diet_package',
    //             'description' => 'ترکیبی از صبحانه، ناهار و عصرانه با کالری کنترل‌شده.',
    //             'price' => 250000,
    //             'kcal' => 1200,
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //         ],
    //     ];

    //     // Insert meals and link images by slug
    //     DB::table('meals')->insert($meals);

    //     foreach ($meals as $meal) {
    //         $slug = $meal['slug'];
    //         $publicPath = public_path("meals/{$slug}.jpg");
    //         $storageRelative = "meals/{$slug}.jpg"; // in storage/app/public
    //         $storageFull = storage_path("app/public/{$storageRelative}");

    //         // Ensure directory exists
    //         Storage::disk('public')->makeDirectory('meals');

    //         // Copy from public if exists (fallbacks possible if needed)
    //         if (file_exists($publicPath)) {
    //             copy($publicPath, $storageFull);
    //         }

    //         // Create image record pointing to storage path
    //         $image = Image::firstOrCreate([
    //             'url' => "{$storageRelative}",
    //         ], [
    //             'alt' => $meal['title'],
    //             'extra' => null,
    //         ]);

    //         // Link meal to image
    //         $mealModel = Meal::where('slug', $slug)->first();
    //         if ($mealModel && $image) {
    //             MealImage::firstOrCreate([
    //                 'meal_id' => $mealModel->id,
    //                 'image_id' => $image->id,
    //             ]);
    //         }
    //     }
    // }
     public function run(): void
    {
        $meals = [
            // SALADS - 7 meals
            [
                'title' => 'پروچیکن سالاد',
                'slug' => 'pro-chicken-salad',
                'description' => 'سالاد پروتئینی با سینه مرغ گریل و پنیر',
                'calories' => 330,
                'price' => 650.000,
                'is_vegan' => false,
                'kcal' => '330 کیلو کالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۳۳۰ کیلوکالری',
                    'کربوهیدرات' => '۲۴.۵ گرم',
                    'پروتئین' => '۲۶.۵ گرم',
                    'چربی' => '۱۴.۵ گرم'
                ]),
                'contraindications' => json_encode([
                    'در مشکلات تیروئیدی و شیردهی و رژیم کتوژنیک قابل استفاده نیست.'
                ]),
                'consumable_items' => json_encode([
                    'بدلیل وجود پنیر منبع خوبی از کلسیم و پروتیین میباشد.',
                    'بدلیل وجود دانه های روغنی منبع مناسبی از چربی‌های مفید و کاهنده چربیهای مضر خون می‌باشد.',
                    'برای کنترل فشار خون ، تولید گلبول قرمز و تعادل هورمونی زنان مناسب است.'
                ]),
            ],
            [
                'title' => 'سالاد سزار ایوا',
                'slug' => 'caesar-eva-salad',
                'description' => 'سالاد سزار ویژه با مرغ و پنیر پارمسان',
                'calories' => 263,
                'price' => 580.000,
                'is_vegan' => false,
                'kcal' => '263 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۲۶۳ کیلوکالری',
                    'کربوهیدرات' => '۱۹ گرم',
                    'پروتئین' => '۲۵ گرم',
                    'چربی' => '۱۰ گرم'
                ]),
                'contraindications' => json_encode([
                    'در رژیم کتوژنیک و کم کاری تیروئید توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'بدلیل وجود فیبر بالا برای سلامت دستگاه گوارش و کلاژن سازی پوست مفید است',
                    'بدلیل وجود مغزهای خوراکی در افزایش سطح چربی مفید خون مناسب است'
                ]),
            ],
            [
                'title' => 'سالاد ایتالیانو',
                'slug' => 'italiano-salad',
                'description' => 'سالاد ایتالیایی با پنیر فتا و کینوا',
                'calories' => 350,
                'price' => 620.000,
                'is_vegan' => false,
                'kcal' => '350 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۳۵۰ کیلوکالری',
                    'کربوهیدرات' => '۲۰ گرم',
                    'پروتئین' => '۲۳ گرم',
                    'چربی' => '۲۰ گرم'
                ]),
                'contraindications' => json_encode([]),
                'consumable_items' => json_encode([]),
            ],
            [
                'title' => 'فارماسالاد',
                'slug' => 'farma-salad',
                'description' => 'سالاد رژیمی با سبزیجات تازه',
                'calories' => 200,
                'price' => 450.000,
                'is_vegan' => true,
                'kcal' => '200 کیلو کالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۲۰۰ کیلو کالری',
                    'پروتئین' => '۲۰ گرم',
                    'کربوهیدرات' => '۱۵ گرم',
                    'چربی' => '۷ گرم'
                ]),
                'contraindications' => json_encode([
                    'در مشکلات تیروئیدی و سنگ کلیه توصیه نمیشود.',
                    'افرادی که به برخی دانه ها حساسیت دارند با احتیاط مصرف شود.'
                ]),
                'consumable_items' => json_encode([
                    'در تقویت سیستم ایمنی و پیشگیری از سرطان و بهبود بینایی موثر است.'
                ]),
            ],
            [
                'title' => 'ماشروم پروسالاد',
                'slug' => 'mushroom-pro-salad',
                'description' => 'سالاد قارچ و مرغ گریل',
                'calories' => 265,
                'price' => 550.000,
                'is_vegan' => false,
                'kcal' => '265 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۲۶۵ کیلوکالری',
                    'کربوهیدرات' => '۳۳ گرم',
                    'پروتئین' => '۱۳ گرم',
                    'چربی' => '۹ گرم'
                ]),
                'contraindications' => json_encode([
                    'افرادیکه حساسیت های غذایی خاص دارند توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'یک وعده غذایی سرشار از ویتامین‌ها و مواد معدنی و آنتی اکسیدانها و فیبرها می‌باشد',
                    'به تقویت سیستم ایمنی بدن کمک می‌کند',
                    'منبع مناسبی از پروتئین بدون چربی میباشد'
                ]),
            ],
            [
                'title' => 'ویتافروت سالاد',
                'slug' => 'vitafruit-salad',
                'description' => 'سالاد میوه های فصل',
                'calories' => 175,
                'price' => 350.000,
                'is_vegan' => true,
                'kcal' => '175 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۱۷۵ کیلوکالری',
                    'کربوهیدرات' => '۴۵ گرم',
                    'پروتئین' => '۲ گرم',
                    'چربی' => '۰ گرم'
                ]),
                'contraindications' => json_encode([
                    'در افرادیکه مشکلات دیابت دارند با احتیاط و با نظر پزشک مصرف شود'
                ]),
                'consumable_items' => json_encode([
                    'این سالاد میوه سرشار از ویتامین‌ها و آنتی اکسیدانها می‌باشد',
                    'تامین کننده آب بدن و انرژی می‌باشد'
                ]),
            ],
            [
                'title' => 'پاستا سالاد',
                'slug' => 'pasta-salad',
                'description' => 'سالاد پاستا با مرغ گریل',
                'calories' => 360,
                'price' => 680.000,
                'is_vegan' => false,
                'kcal' => '360 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۳۶۰ کیلوکالری',
                    'کربوهیدرات' => '۳۵ گرم',
                    'پروتئین' => '۴۰ گرم',
                    'چربی' => '۵ گرم'
                ]),
                'contraindications' => json_encode([
                    'بدلیل وجود پاستا برای رژیم‌های گلوتن فری و بیماران سلیاکی توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'یک وعده غذایی سالم و انرژیک می‌باشد',
                    'بدلیل وجود بروکلی و فلفل دلمه سرشار از ویتامین و مواد آنتی اکسیدانی میباشد'
                ]),
            ],

            // SANDWICHES - 4 meals
            [
                'title' => 'ساندویچ مرغ پستو',
                'slug' => 'chicken-pesto-sandwich',
                'description' => 'ساندویچ مرغ با سس پستو',
                'calories' => 340,
                'price' => 420.000,
                'is_vegan' => false,
                'kcal' => '340 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۳۴۰ کیلوکالری',
                    'پروتئین' => '۳۰ گرم',
                    'کربوهیدرات' => '۴۰ گرم',
                    'چربی' => '۶ گرم'
                ]),
                'contraindications' => json_encode([
                    'در رژیم‌های گلوتن فری و بیماران سلیاکی توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'یک وعده غذایی سالم و سبک که انرژی مورد نیاز بدن را تامین میکند',
                    'به عضله سازی کمک میکند'
                ]),
            ],
            [
                'title' => 'گرین ساندویچ',
                'slug' => 'green-sandwich',
                'description' => 'ساندویچ سبز با فیله مرغ',
                'calories' => 410,
                'price' => 480.000,
                'is_vegan' => false,
                'kcal' => '410 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۴۱۰ کیلوکالری',
                    'کربوهیدرات' => '۳۵ گرم',
                    'پروتئین' => '۳۸ گرم',
                    'چربی' => '۱۳ گرم'
                ]),
                'contraindications' => json_encode([
                    'در رژیم‌های گلوتن فری توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'منبع مناسبی از پروتئین و برای عضله سازی مناسب است',
                    'سرشار از کلسیم میباشد'
                ]),
            ],
            [
                'title' => 'چیز تست',
                'slug' => 'cheese-toast',
                'description' => 'تست پنیر و بادام زمینی',
                'calories' => 295,
                'price' => 320.000,
                'is_vegan' => false,
                'kcal' => '295 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۲۹۵ کیلوکالری',
                    'کربوهیدرات' => '۳۵ گرم',
                    'پروتئین' => '۱۶ گرم',
                    'چربی' => '۱۰ گرم'
                ]),
                'contraindications' => json_encode([
                    'جهت افرادیکه به دانه های روغنی آلرژی دارند توصیه نمیشود',
                    'در رژیم های گلوتن فری قابل استفاده نیست'
                ]),
                'consumable_items' => json_encode([
                    'برای افراد دارای رژیم وگان مناسب است',
                    'بدلیل وجود بادام زمینی و زیتون منبع مناسبی از چربی‌های مفید می‌باشد',
                    'بعنوان یک وعده غذایی سالم و سبک میتونن استفاده نمود'
                ]),
            ],
            [
                'title' => 'چیزساندویچ',
                'slug' => 'cheese-sandwich',
                'description' => 'ساندویچ پنیر و مرغ',
                'calories' => 430,
                'price' => 450.000,
                'is_vegan' => false,
                'kcal' => '430 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۴۳۰ کیلوکالری',
                    'کربوهیدرات' => '۴۰ گرم',
                    'پروتئین' => '۳۵ گرم',
                    'چربی' => '۱۵ گرم'
                ]),
                'contraindications' => json_encode([
                    'در رژیم‌های کم کربوهیدرات و گلوتن فری و بیماران سلیاکی توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'منبع مناسبی از پروتئین و جهت عضله سازی موثر است',
                    'بدلیل وجود کنجد منبع مناسبی از چربی مفید و بدون کلسترول می‌باشد'
                ]),
            ],

            // BREAKFAST - 4 meals
            [
                'title' => 'تست فرانسوی',
                'slug' => 'french-toast',
                'description' => 'تست فرانسوی با تخم مرغ و عسل',
                'calories' => 465,
                'price' => 380.000,
                'is_vegan' => false,
                'kcal' => '465 کیلو کالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۴۶۵ کیلو کالری',
                    'کربوهیدرات' => '۴۳ گرم',
                    'پروتئین' => '۲۶ گرم',
                    'چربی' => '۲۱ گرم'
                ]),
                'contraindications' => json_encode([
                    'در رژیم های کم کربوهیدرات و گلوتن فری توصیه نمیشود',
                    'افراد با شرایط پزشکی خاص (مانند دیابت کنترل نشده یا کلسترول بسیار بالا) باید طبق دستور پزشک خود مصرف کنند'
                ]),
                'consumable_items' => json_encode([
                    'یک صبحانه قوی و انرژیک می‌باشد که برای مدتها شما را سیر نگه میدارد',
                    'بدلیل وجود تخم مرغ منبع عالی از پروتئین و ویتامین دی و آنتی اکسیدان‌های قوی',
                    'در بهبود بینایی موثر است',
                    'به تقویت سلامت مغز و حافظه تقویت چشم هاو تقویت پوست و مو میگردد'
                ]),
            ],
            [
                'title' => 'پینات تست',
                'slug' => 'peanut-toast',
                'description' => 'تست کره بادام زمینی با دانه چیا',
                'calories' => 460,
                'price' => 360.000,
                'is_vegan' => false,
                'kcal' => '460 کیلو کالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۴۶۰ کیلو کالری',
                    'کربوهیدرات' => '۴۲ گرم',
                    'پروتئین' => '۱۶ گرم',
                    'چربی' => '۲۷ گرم'
                ]),
                'contraindications' => json_encode([
                    'در افرادیکه به گلوتن و بادام زمینی آلرژی دارند توصیه نمیشود',
                    'در اشخاص دارای مشکلات گوارشی خاص مثل سندروم روده تحریک پذیر و یا سوءهاضمه توصیه نمیشود',
                    'افراد در حال کاهش وزن و رژیم کم کالری با احتیاط مصرف شود',
                    'افراد دارای بیماری کلیوی خاص توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'انرژی را به تدریج در بدن شما آزاد می‌کند و برای ساعت‌ها شما را سیر و پرانرژی نگه می‌دارد',
                    'بدلیل وجود دانه چیا سرشار از فیبر، اسیدهای چرب امگا-۳ و ریز مغذی‌ها است',
                    'یک انتخاب عالی برای روزهای پرمشغله یا قبل از بک فعالیت ورزشی است'
                ]),
            ],
            [
                'title' => 'تست پنیر و خرما',
                'slug' => 'cheese-date-toast',
                'description' => 'تست پنیر فتا با خرما',
                'calories' => 330,
                'price' => 340.000,
                'is_vegan' => false,
                'kcal' => '330 کیلو کالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۳۳۰ کیلو کالری',
                    'کربوهیدرات' => '۵۵ گرم',
                    'پروتئین' => '۱۲ گرم',
                    'چربی' => '۷ گرم'
                ]),
                'contraindications' => json_encode([
                    'افرادیکه مشکلات دیابتی دارند و رژیم‌های گلوتن فری توصیه نمیشود'
                ]),
                'consumable_items' => json_encode([
                    'خرما با قندهای طبیعی خود (فروکتوز و گلوکز)، یک منبع انرژی فوری برای مغز و بدن است',
                    'به رفع خستگی صبحگاهی کمک می‌کند',
                    'خرما سرشار از فیبر است که به تنظیم حرکات روده و پیشگیری از یبوست کمک می‌کند',
                    'پنیر و کنجد هم منبع بسیار خوبی از کلسیم و فسفر هستند'
                ]),
            ],
            [
                'title' => 'چیز تست ارده ای',
                'slug' => 'cheese-tahini-toast',
                'description' => 'تست پنیر با ارده و موز',
                'calories' => 420,
                'price' => 400.000,
                'is_vegan' => false,
                'kcal' => '420 کیلوکالری',
                'nutritional_informations' => json_encode([
                    'انرژی' => '۴۲۰ کیلوکالری',
                    'کربوهیدرات' => '۵۵ گرم',
                    'پروتئین' => '۱۵ گرم',
                    'چربی' => '۱۶ گرم'
                ]),
                'contraindications' => json_encode([
                    'افراد دارای حساسیت های غذایی، سندروم روده تحریک پذیر (IBS) و در رژیم‌های گلوتن فری مصرف نشود'
                ]),
                'consumable_items' => json_encode([
                    'نان سبوس‌دار و موز هر دو سرشار از فیبر هستند که باعث بهبود دستگاه گوارش و پیشگیری از یبوست می‌شوند',
                    'ارده و پنیر هر دو منبع بسیار خوبی از کلسیم هستند',
                    'ارده سرشار از اسیدهای چرب غیراشباع و "فیتوسترول‌ها" است که به کاهش کلسترول بد (LDL) و حفظ سلامت قلب کمک می‌کنند'
                ]),
            ]
        ];

        DB::table('meals')->insert($meals);
    }
}
