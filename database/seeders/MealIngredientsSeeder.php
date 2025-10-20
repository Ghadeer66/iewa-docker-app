<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealIngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $mealIngredients = [
            // SALADS
            // 1. پروچیکن سالاد
            ['meal_id' => 1, 'ingredient_id' => 1], // سینه مرغ گریل
            ['meal_id' => 1, 'ingredient_id' => 2], // پنیر
            ['meal_id' => 1, 'ingredient_id' => 3], // کاهو پیچ
            ['meal_id' => 1, 'ingredient_id' => 4], // کلم قرمز
            ['meal_id' => 1, 'ingredient_id' => 5], // هویج
            ['meal_id' => 1, 'ingredient_id' => 6], // پیازچه
            ['meal_id' => 1, 'ingredient_id' => 7], // جعفری
            ['meal_id' => 1, 'ingredient_id' => 8], // ریحان
            ['meal_id' => 1, 'ingredient_id' => 9], // مغز تخمه آفتابگردان
            ['meal_id' => 1, 'ingredient_id' => 10], // کنجد
            ['meal_id' => 1, 'ingredient_id' => 11], // بروکلی

            // 2. سالاد سزار ایوا
            ['meal_id' => 2, 'ingredient_id' => 1], // سینه مرغ
            ['meal_id' => 2, 'ingredient_id' => 3], // کاهو پیچ
            ['meal_id' => 2, 'ingredient_id' => 12], // گوجه چری
            ['meal_id' => 2, 'ingredient_id' => 9], // تخم آفتابگردان
            ['meal_id' => 2, 'ingredient_id' => 13], // تخم کتان
            ['meal_id' => 2, 'ingredient_id' => 14], // زیتون
            ['meal_id' => 2, 'ingredient_id' => 15], // کاپاریس
            ['meal_id' => 2, 'ingredient_id' => 16], // پنیر پارمسان

            // 3. سالاد ایتالیانو
            ['meal_id' => 3, 'ingredient_id' => 3], // کاهو
            ['meal_id' => 3, 'ingredient_id' => 14], // زیتون
            ['meal_id' => 3, 'ingredient_id' => 12], // گوجه چری
            ['meal_id' => 3, 'ingredient_id' => 17], // پنیر فتا
            ['meal_id' => 3, 'ingredient_id' => 18], // کینوا
            ['meal_id' => 3, 'ingredient_id' => 19], // ذرت
            ['meal_id' => 3, 'ingredient_id' => 20], // لوبیا قرمز
            ['meal_id' => 3, 'ingredient_id' => 21], // تخم مرغ

            // 4. فارماسالاد
            ['meal_id' => 4, 'ingredient_id' => 22], // بیبی اسفناج
            ['meal_id' => 4, 'ingredient_id' => 11], // بروکلی
            ['meal_id' => 4, 'ingredient_id' => 5], // هویج
            ['meal_id' => 4, 'ingredient_id' => 23], // سیاهدانه
            ['meal_id' => 4, 'ingredient_id' => 9], // تخم آفتابگردان
            ['meal_id' => 4, 'ingredient_id' => 24], // کدو
            ['meal_id' => 4, 'ingredient_id' => 25], // لبو
            ['meal_id' => 4, 'ingredient_id' => 20], // لوبیا

            // 5. ماشروم پروسالاد
            ['meal_id' => 5, 'ingredient_id' => 11], // بروکلی
            ['meal_id' => 5, 'ingredient_id' => 1], // مرغ گریل
            ['meal_id' => 5, 'ingredient_id' => 26], // قارچ
            ['meal_id' => 5, 'ingredient_id' => 27], // سیب زمینی تنوری
            ['meal_id' => 5, 'ingredient_id' => 22], // بیبی اسفناج
            ['meal_id' => 5, 'ingredient_id' => 16], // پنیر پارمسان
            ['meal_id' => 5, 'ingredient_id' => 28], // دانه چیا

            // 6. ویتافروت سالاد
            ['meal_id' => 6, 'ingredient_id' => 29], // سیب درختی
            ['meal_id' => 6, 'ingredient_id' => 30], // انار
            ['meal_id' => 6, 'ingredient_id' => 31], // موز
            ['meal_id' => 6, 'ingredient_id' => 32], // پرتقال
            ['meal_id' => 6, 'ingredient_id' => 33], // کیوی

            // 7. پاستا سالاد
            ['meal_id' => 7, 'ingredient_id' => 1], // مرغ گریل
            ['meal_id' => 7, 'ingredient_id' => 34], // پاستا
            ['meal_id' => 7, 'ingredient_id' => 10], // کنجد
            ['meal_id' => 7, 'ingredient_id' => 11], // بروکلی
            ['meal_id' => 7, 'ingredient_id' => 35], // فلفل دلمه رنگی
            ['meal_id' => 7, 'ingredient_id' => 16], // پنیر پارمسان

            // SANDWICHES
            // 8. ساندویچ مرغ پستو
            ['meal_id' => 8, 'ingredient_id' => 36], // فیله مرغ
            ['meal_id' => 8, 'ingredient_id' => 12], // گوجه چری
            ['meal_id' => 8, 'ingredient_id' => 37], // نان
            ['meal_id' => 8, 'ingredient_id' => 3], // کاهو
            ['meal_id' => 8, 'ingredient_id' => 38], // سس پستو

            // 9. گرین ساندویچ
            ['meal_id' => 9, 'ingredient_id' => 37], // نان
            ['meal_id' => 9, 'ingredient_id' => 36], // فیله مرغ
            ['meal_id' => 9, 'ingredient_id' => 39], // دیپ فلفل دلمه
            ['meal_id' => 9, 'ingredient_id' => 14], // زیتون
            ['meal_id' => 9, 'ingredient_id' => 3], // کاهو

            // 10. چیز تست
            ['meal_id' => 10, 'ingredient_id' => 40], // نان تست هفت غله
            ['meal_id' => 10, 'ingredient_id' => 41], // پنیر فتا کم چرب
            ['meal_id' => 10, 'ingredient_id' => 14], // زیتون
            ['meal_id' => 10, 'ingredient_id' => 27], // گوجه خشک
            ['meal_id' => 10, 'ingredient_id' => 42], // بادام زمینی

            // 11. چیزساندویچ
            ['meal_id' => 11, 'ingredient_id' => 43], // نان چاپاتا
            ['meal_id' => 11, 'ingredient_id' => 44], // پنیر ورقه ای
            ['meal_id' => 11, 'ingredient_id' => 36], // مرغ
            ['meal_id' => 11, 'ingredient_id' => 27], // گوجه خشک
            ['meal_id' => 11, 'ingredient_id' => 10], // کنجد
            ['meal_id' => 11, 'ingredient_id' => 3], // کاهو

            // BREAKFAST
            // 12. تست فرانسوی
            ['meal_id' => 12, 'ingredient_id' => 45], // نان تست
            ['meal_id' => 12, 'ingredient_id' => 21], // تخم مرغ
            ['meal_id' => 12, 'ingredient_id' => 10], // کنجد
            ['meal_id' => 12, 'ingredient_id' => 46], // عسل ساشه ای

            // 13. پینات تست
            ['meal_id' => 13, 'ingredient_id' => 45], // نان تست
            ['meal_id' => 13, 'ingredient_id' => 47], // کره بادام زمینی
            ['meal_id' => 13, 'ingredient_id' => 28], // دانه چیا

            // 14. تست پنیر و خرما
            ['meal_id' => 14, 'ingredient_id' => 48], // نان تست سبوس دار
            ['meal_id' => 14, 'ingredient_id' => 41], // پنیر فتا کم چرب
            ['meal_id' => 14, 'ingredient_id' => 49], // خرما
            ['meal_id' => 14, 'ingredient_id' => 10], // کنجد

            // 15. چیز تست ارده ای
            ['meal_id' => 15, 'ingredient_id' => 48], // نان تست سبوس دار
            ['meal_id' => 15, 'ingredient_id' => 41], // پنیر فتا کم چرب
            ['meal_id' => 15, 'ingredient_id' => 50], // ارده
            ['meal_id' => 15, 'ingredient_id' => 31], // موز
        ];

        DB::table('meal_ingredients')->insert($mealIngredients);
    }
}
