<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $meals = Meal::take(6)->with('mealImage.image')->get();
        foreach ($meals as $meal) {
            $meal->image_url = $meal->getImageUrlAttribute(); // Access the accessor to set the attribute
        }
        return Inertia::render('Home/Index', [
            'meals' => $meals
        ]);
    }
}
