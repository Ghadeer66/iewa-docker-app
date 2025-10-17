<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealImage;
use App\Models\Meal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class MealImageController extends Controller
{
    public function index()
    {
        $mealImages = MealImage::with(['meal', 'image'])
            ->latest()
            ->get()
            ->map(function ($mealImage) {
                // Ensure the URL is correct
                if ($mealImage->image) {
                    $mealImage->image->url = $this->getImageUrl($mealImage->image->path);
                }
                return $mealImage;
            });

        $meals = Meal::select('id', 'title')
            ->get();

        return Inertia::render('Admin/MealsImages', [
            'mealImages' => $mealImages,
            'meals' => $meals
        ]);
    }

    private function getImageUrl($path)
    {
        if (!$path) {
            return null;
        }

        // Remove any leading slashes or 'storage/' prefixes that might cause issues
        $path = ltrim($path, '/');
        $path = str_replace('storage/', '', $path);

        return asset("storage/{$path}");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'image_path' => 'required|string|max:255',
            'is_primary' => 'boolean'
        ]);

        // Clean the image path before storing
        $validated['image_path'] = $this->cleanImagePath($validated['image_path']);

        // If setting as primary, remove primary status from other images of the same meal
        if ($validated['is_primary']) {
            MealImage::where('meal_id', $validated['meal_id'])
                ->update(['is_primary' => false]);
        }

        MealImage::create($validated);

        return redirect()->back()->with('success', 'تصویر غذا با موفقیت افزوده شد.');
    }

    private function cleanImagePath($path)
    {
        // Remove any domain or full URL parts, keep only the storage path
        $path = str_replace(url(''), '', $path);
        $path = str_replace('storage/', '', $path);
        return ltrim($path, '/');
    }

    public function destroy(MealImage $mealImage)
    {
        $mealImage->delete();
        return redirect()->back()->with('success', 'تصویر غذا با موفقیت حذف شد.');
    }
}
