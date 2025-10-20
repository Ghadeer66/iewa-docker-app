<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Category;
use App\Models\Type;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $meals = Meal::take(6)
                    ->with(['images'])
                    ->get()
                    ->map(function ($meal) {
                        $meal->image_url = $meal->images->first()
                            ? asset($meal->images->first()->url)
                            : null;
                        return $meal;
                    });

        // Get categories and types for the home page
        $categories = Category::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'persian_title' => $this->mapCategoryToPersian($category->title),
            ];
        });

        $types = Type::all()->map(function ($type) {
            return [
                'id' => $type->id,
                'title' => $type->title,
                'persian_title' => $this->mapTypeToPersian($type->title),
            ];
        });

        return Inertia::render('Home/Index', [
            'meals' => $meals,
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    private function mapCategoryToPersian($englishTitle)
    {
        $map = [
            'economic' => 'لاین غذای اقتصادی',
            'package' => 'پک میانوعده',
            'salad' => 'سالاد',
            'sandwich' => 'ساندویچ',
            'cake' => 'کیک و نان',
            'coffee' => 'دمنوش و قهوه',
            'drinks' => 'نوشیدنی',
            'ott-meal' => 'اوتمیل',
            'breakfast' => 'صبحانه',
            'dessert' => 'دسیرت‌ها',
        ];

        return $map[$englishTitle] ?? $englishTitle;
    }

    private function mapTypeToPersian($englishTitle)
    {
        $map = [
            'light' => 'لایت',
            'diet' => 'رژیمی',
            'energy' => 'انرژیک',
            'caffeine' => 'کافئین',
            'school' => 'مدرسه',
        ];

        return $map[$englishTitle] ?? $englishTitle;
    }
}
