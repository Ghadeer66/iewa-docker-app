<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $meals = Meal::paginate(12);

        // add full URL for frontend
        $meals->getCollection()->transform(function ($meal) {
            $meal->image_url = $meal->image ? asset('storage/'.$meal->image) : null;
            return $meal;
        });

        return Inertia::render('Menu/Index', [
            'meals' => $meals
        ]);
    }
}
