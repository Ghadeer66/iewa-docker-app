<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\IngredientController;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            \Database\Seeders\SectionTypeSeeder::class,
            \Database\Seeders\ImagesSeeder::class,
            \Database\Seeders\BusinessRoleSeeder::class,
            \Database\Seeders\AssignBusinessRoleToUsersSeeder::class,
            TypeSeeder::class,
            CategoriesSeeder::class,
            IngredientsSeeder::class,
            \Database\Seeders\MealsSeeder::class,
            MealCategoriesSeeder::class,
            MealTypeSeeder::class,
            MealIngredientsSeeder::class,
            MealsImagesSeeder::class,
            ComprehensiveMealSeeder::class,
        ]);
    }
}
