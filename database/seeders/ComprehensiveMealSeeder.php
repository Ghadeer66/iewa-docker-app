<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Image;

class ComprehensiveMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Get type and category IDs
        $typeIds = Type::pluck('id', 'title')->toArray();
        $categoryIds = Category::pluck('id', 'title')->toArray();

        // Define category to image mapping
        $categoryImageMapping = [
            'salad' => 'images/default-meals-images/salad.jpg',
            'drinks' => 'images/default-meals-images/drinks.jpg',
            'economic' => 'images/default-meals-images/economic.jpg',
            'sandwich' => 'images/default-meals-images/sandwich.jpg',
            'breakfast' => 'images/default-meals-images/breakfast.jpg',
            'cake' => 'images/default-meals-images/cake.jpg',
            'dessert' => 'images/default-meals-images/dessert.jpg',
            'ott-meal' => 'images/default-meals-images/ott-meal.jpg',
            'coffee' => 'images/default-meals-images/coffee.jpg',

        ];

        // Create or get image records for each category
        $categoryImageIds = [];
        foreach ($categoryImageMapping as $category => $imageUrl) {
            $image = Image::firstOrCreate(
                ['url' => $imageUrl],
                [
                    'alt' => ucfirst(str_replace('-', ' ', $category)),
                    'extra' => "Default image for {$category} category"
                ]
            );
            $categoryImageIds[$category] = $image->id;
        }

        // Define the meal data structure
        $mealData = [
            [
                "type" => "light",
                "categories" => [
                    [
                        "category" => "drinks",
                        "meals" => [
                            ["title" => "پرتقال", "price" => 60000, "calories" => 80]
                        ]
                    ]
                ]
            ],
            [
                "type" => "energy",
                "categories" => [
                    [
                        "category" => "drinks",
                        "meals" => [
                            ["title" => "شیرشکلات", "price" => 180000, "calories" => 250],
                            ["title" => "معجون انرژی درینک", "price" => 140000, "calories" => 320]
                        ]
                    ],
                    [
                        "category" => "dessert",
                        "meals" => [
                            ["title" => "دسر شکلاتی", "price" => 220000, "calories" => 280],
                            ["title" => "دسر دورنگ قهوه شکلات", "price" => 240000, "calories" => 310]
                        ]
                    ]
                ]
            ],
            [
                "type" => "diet",
                "categories" => [
                    [
                        "category" => "drinks",
                        "meals" => [
                            ["title" => "رد فروت میکس", "price" => 70000, "calories" => 120],
                            ["title" => "اسموتی نعنازنحبیل", "price" => 180000, "calories" => 140],
                            ["title" => "نوشیدنی بیدمشک", "price" => 50000, "calories" => 50],
                            ["title" => "نوشیدنی بهار نارنج", "price" => 50000, "calories" => 55],
                            ["title" => " موهیتو ", "price" => 60000, "calories" => 90],

                        ]
                    ],
                    [
                        "category" => "coffee",
                        "meals" => [
                            ["title" => "دمنوشته بری درینک", "price" => 180000, "calories" => 45]
                        ]
                    ],
                    [
                        "category" => "dessert",
                        "meals" => [
                            ["title" => "ویتافروت میکس", "price" => 200000, "calories" => 180]
                        ]
                    ],
                    [
                        "category" => "ott-meal",
                        "meals" => [
                            ["title" => "اوتمیل چیا", "price" => 220000, "calories" => 350]
                        ]
                    ]
                ]
            ],
            [
                "type" => "caffeine",
                "categories" => [
                    [
                        "category" => "coffee",
                        "meals" => [
                            ["title" => "کافی میلک", "price" => 70000, "calories" => 150],
                            ["title" => "کول لته", "price" => 65000, "calories" => 180],
                            ["title" => "آمریکانو", "price" => 60000, "calories" => 10],
                            ["title" => "چیلی کافی", "price" => 70000, "calories" => 120]
                        ]
                    ],
                    [
                        "category" => "dessert",
                        "meals" => [
                            ["title" => "دسر قهوه", "price" => 230000, "calories" => 290]
                        ]
                        ],
                        [
                        "category" => "ott-meal",
                        "meals" => [
                            ["title" => "اوتمیل قهوه", "price" => 220000, "calories" => 380]
                        ]
                    ]
                ]
            ]
        ];

        $mealTypeRelations = [];
        $mealCategoryRelations = [];
        $mealImageRelations = [];
        $mealsToInsert = [];
        $mealCounter = 1;
        $insertedMealIds = [];
        $mealSlugToRelations = []; // Track relationships by slug for accurate mapping

        foreach ($mealData as $typeData) {
            $typeTitle = $typeData['type'];
            $typeId = $typeIds[$typeTitle] ?? null;

            if (!$typeId) {
                $this->command->warn("Type '{$typeTitle}' not found in database. Skipping...");
                continue;
            }

            foreach ($typeData['categories'] as $categoryData) {
                $categoryTitle = $categoryData['category'];
                $categoryId = $categoryIds[$categoryTitle] ?? null;

                if (!$categoryId) {
                    $this->command->warn("Category '{$categoryTitle}' not found in database. Skipping...");
                    continue;
                }

                foreach ($categoryData['meals'] as $mealInfo) {
                    $title = $mealInfo['title'];
                    $slug = Str::slug($title, '-');

                    // Check if slug already exists and make it unique
                    $originalSlug = $slug;
                    $counter = 1;
                    while (DB::table('meals')->where('slug', $slug)->exists()) {
                        $slug = $originalSlug . '-' . $counter;
                        $counter++;
                    }

                    // Get price from mealInfo or use random default
                    $price = $mealInfo['price'] ?? rand(250000, 800000);
                    $calories = $mealInfo['calories'] ?? rand(150, 500);

                    // Create meal data
                    $mealsToInsert[] = [
                        'title' => $title,
                        'slug' => $slug,
                        'description' => "توضیحات {$title}",
                        'calories' => $calories,
                        'price' => $price,
                        'is_vegan' => rand(0, 1) == 1,
                        'kcal' => $calories,
                        'nutritional_informations' => json_encode([
                            'انرژی' => rand(150, 500) . ' کیلوکالری',
                            'کربوهیدرات' => rand(20, 60) . ' گرم',
                            'پروتئین' => rand(10, 40) . ' گرم',
                            'چربی' => rand(5, 25) . ' گرم'
                        ]),
                        'contraindications' => json_encode([
                            'در صورت حساسیت غذایی با احتیاط مصرف شود'
                        ]),
                        'consumable_items' => json_encode([
                            'منبع مناسبی از مواد مغذی و انرژی'
                        ]),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    // Store relationships by slug for accurate mapping
                    $mealSlugToRelations[$slug] = [
                        'type_id' => $typeId,
                        'category_id' => $categoryId,
                        'image_id' => $categoryImageIds[$categoryTitle] ?? null,
                    ];

                    $insertedMealIds[] = $mealCounter;
                    $mealCounter++;
                }
            }
        }

        // Insert meals
        if (!empty($mealsToInsert)) {
            DB::table('meals')->insert($mealsToInsert);
            $this->command->info("Inserted " . count($mealsToInsert) . " meals.");

            // Get the actual meal IDs that were just inserted
            $actualMealIds = DB::table('meals')
                ->whereIn('slug', array_column($mealsToInsert, 'slug'))
                ->pluck('id', 'slug')
                ->toArray();

            // Create relationships using slug-based mapping
            foreach ($mealSlugToRelations as $slug => $relations) {
                if (isset($actualMealIds[$slug])) {
                    $mealId = $actualMealIds[$slug];

                    // Add type relationship
                    $mealTypeRelations[] = [
                        'meal_id' => $mealId,
                        'type_id' => $relations['type_id'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    // Add category relationship
                    $mealCategoryRelations[] = [
                        'meal_id' => $mealId,
                        'category_id' => $relations['category_id'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    // Add image relationship if available
                    if ($relations['image_id']) {
                        $mealImageRelations[] = [
                            'meal_id' => $mealId,
                            'image_id' => $relations['image_id'],
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }
            }
        }

        // Insert meal-type relationships
        if (!empty($mealTypeRelations)) {
            DB::table('meal_type')->insert($mealTypeRelations);
            $this->command->info("Inserted " . count($mealTypeRelations) . " meal-type relationships.");
        }

        // Insert meal-category relationships
        if (!empty($mealCategoryRelations)) {
            DB::table('meal_categories')->insert($mealCategoryRelations);
            $this->command->info("Inserted " . count($mealCategoryRelations) . " meal-category relationships.");
        }

        // Insert meal-image relationships
        if (!empty($mealImageRelations)) {
            DB::table('meals_images')->insert($mealImageRelations);
            $this->command->info("Inserted " . count($mealImageRelations) . " meal-image relationships.");
        }

        $this->command->info("Comprehensive meal seeder completed successfully!");
    }
}
