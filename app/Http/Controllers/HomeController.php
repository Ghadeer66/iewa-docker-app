<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $meals = Meal::take(6)->get();
        return Inertia::render('Home/Index', [
            'meals' => $meals
        ]);
    }
}
