<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $ingredients = [
            // Salad ingredients
            ['title' => 'سینه مرغ گریل', 'amount' => 150, 'unit' => 'گرم'],
            ['title' => 'پنیر', 'amount' => 50, 'unit' => 'گرم'],
            ['title' => 'کاهو پیچ', 'amount' => 100, 'unit' => 'گرم'],
            ['title' => 'کلم قرمز', 'amount' => 50, 'unit' => 'گرم'],
            ['title' => 'هویج', 'amount' => 60, 'unit' => 'گرم'],
            ['title' => 'پیازچه', 'amount' => 20, 'unit' => 'گرم'],
            ['title' => 'جعفری', 'amount' => 10, 'unit' => 'گرم'],
            ['title' => 'ریحان', 'amount' => 10, 'unit' => 'گرم'],
            ['title' => 'مغز تخمه آفتابگردان', 'amount' => 15, 'unit' => 'گرم'],
            ['title' => 'کنجد', 'amount' => 10, 'unit' => 'گرم'],
            ['title' => 'بروکلی', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'گوجه چری', 'amount' => 70, 'unit' => 'گرم'],
            ['title' => 'تخم کتان', 'amount' => 10, 'unit' => 'گرم'],
            ['title' => 'زیتون', 'amount' => 30, 'unit' => 'گرم'],
            ['title' => 'کاپاریس', 'amount' => 5, 'unit' => 'گرم'],
            ['title' => 'پنیر پارمسان', 'amount' => 40, 'unit' => 'گرم'],
            ['title' => 'پنیر فتا', 'amount' => 60, 'unit' => 'گرم'],
            ['title' => 'کینوا', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'ذرت', 'amount' => 50, 'unit' => 'گرم'],
            ['title' => 'لوبیا قرمز', 'amount' => 60, 'unit' => 'گرم'],
            ['title' => 'تخم مرغ', 'amount' => 2, 'unit' => 'عدد'],
            ['title' => 'بیبی اسفناج', 'amount' => 100, 'unit' => 'گرم'],
            ['title' => 'سیاهدانه', 'amount' => 5, 'unit' => 'گرم'],
            ['title' => 'کدو', 'amount' => 70, 'unit' => 'گرم'],
            ['title' => 'لبو', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'قارچ', 'amount' => 100, 'unit' => 'گرم'],
            ['title' => 'سیب زمینی تنوری', 'amount' => 120, 'unit' => 'گرم'],
            ['title' => 'دانه چیا', 'amount' => 10, 'unit' => 'گرم'],
            ['title' => 'سیب درختی', 'amount' => 100, 'unit' => 'گرم'],
            ['title' => 'انار', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'موز', 'amount' => 100, 'unit' => 'گرم'],
            ['title' => 'پرتقال', 'amount' => 120, 'unit' => 'گرم'],
            ['title' => 'کیوی', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'پاستا', 'amount' => 150, 'unit' => 'گرم'],
            ['title' => 'فلفل دلمه رنگی', 'amount' => 80, 'unit' => 'گرم'],

            // Sandwich ingredients
            ['title' => 'فیله مرغ', 'amount' => 120, 'unit' => 'گرم'],
            ['title' => 'نان', 'amount' => 100, 'unit' => 'گرم'],
            ['title' => 'سس پستو', 'amount' => 20, 'unit' => 'گرم'],
            ['title' => 'دیپ فلفل دلمه', 'amount' => 25, 'unit' => 'گرم'],
            ['title' => 'نان تست هفت غله', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'پنیر فتا کم چرب', 'amount' => 50, 'unit' => 'گرم'],
            ['title' => 'گوجه خشک', 'amount' => 30, 'unit' => 'گرم'],
            ['title' => 'بادام زمینی', 'amount' => 20, 'unit' => 'گرم'],
            ['title' => 'نان چاپاتا', 'amount' => 120, 'unit' => 'گرم'],
            ['title' => 'پنیر ورقه ای', 'amount' => 40, 'unit' => 'گرم'],

            // Breakfast ingredients
            ['title' => 'نان تست', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'عسل ساشه ای', 'amount' => 15, 'unit' => 'گرم'],
            ['title' => 'کره بادام زمینی', 'amount' => 30, 'unit' => 'گرم'],
            ['title' => 'خرما', 'amount' => 40, 'unit' => 'گرم'],
            ['title' => 'نان تست سبوس دار', 'amount' => 80, 'unit' => 'گرم'],
            ['title' => 'ارده', 'amount' => 25, 'unit' => 'گرم'],
        ];

        DB::table('ingredients')->insert($ingredients);
    }
}
