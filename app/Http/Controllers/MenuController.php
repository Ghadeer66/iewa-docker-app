<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Category;
use App\Models\Type;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Meal::with(['categories', 'types', 'ingredients', 'images']);

        // Apply category filter
        if ($request->has('category') && $request->category !== 'همه') {
            $categoryFilter = $this->mapFilterToCategory($request->category);
            if ($categoryFilter) {
                $query->whereHas('categories', function ($q) use ($categoryFilter) {
                    $q->where('title', $categoryFilter);
                });
            }
        }

        // Apply type filter
        if ($request->has('type') && $request->type) {
            $typeFilter = $this->mapFilterToType($request->type);
            if ($typeFilter) {
                $query->whereHas('types', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            }
        }

        $meals = $query->paginate(12);

        // Add full URL for images and fix pagination URLs
        $meals->getCollection()->transform(function ($meal) {
            if ($meal->images->isNotEmpty()) {
                $meal->image_url = asset($meal->images->first()->url);
            } else {
                $meal->image_url = null;
            }
            return $meal;
        });

        // Fix pagination URLs to include current filters
        $meals->appends($request->except('page'));

        return Inertia::render('Menu/Index', [
            'meals' => $meals,
            'pagination' => [
                'current_page' => $meals->currentPage(),
                'last_page' => $meals->lastPage(),
                'per_page' => $meals->perPage(),
                'total' => $meals->total(),
                'prev_page_url' => $meals->previousPageUrl(),
                'next_page_url' => $meals->nextPageUrl(),
            ],
            'filters' => [
                'category' => $request->category ?? 'همه',
                'type' => $request->type ?? null,
            ]
        ]);
    }

    private function mapFilterToCategory($filterTitle)
    {
        $categoryMap = [
            'لاین غذای اقتصادی' => 'economic',
            'پک میانوعده' => 'package',
            'سالاد' => 'salad',
            'ساندویچ' => 'sandwich',
            'کیک و نان' => 'cake',
            'دمنوش و قهوه' => 'coffee',
            'نوشیدنی' => 'drinks',
            'اوتمیل' => 'ott-meal',
            'صبحانه' => 'breakfast',
            'دسیرت‌ها' => 'dessert',
        ];

        return $categoryMap[$filterTitle] ?? null;
    }

    private function mapFilterToType($filterTitle)
    {
        $typeMap = [
            'لایت' => 'light',
            'رژیمی' => 'diet',
            'انرژیک' => 'energy',
            'کافئین' => 'caffeine',
            'مدرسه' => 'school',
        ];

        return $typeMap[$filterTitle] ?? null;
    }
}
