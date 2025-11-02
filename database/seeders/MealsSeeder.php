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
    public function run()
    {
        $this->call([
            BreakfastMealSeeder::class,
            EconomicMealSeeder::class,
            PackageMealSeeder::class,
            SaladMealsSeeder::class,
            SandwichMealSeeder::class,
            CakeMealSeeder::class,
            // ComprehensiveMealSeeder::class
            DessertMealSeeder::class,
            DrinksMealSeeder::class,
            OttMealSeeder::class,
            CoffeeMealSeeder::class,

        ]);
    }
}
