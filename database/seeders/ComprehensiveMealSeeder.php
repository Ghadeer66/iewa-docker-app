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
            'package' => 'images/default-meals-images/package.jpg',
            'sandwich' => 'images/default-meals-images/sandwich.jpg',
            'breakfast' => 'images/default-meals-images/breakfast.jpg',
            'cake' => 'images/default-meals-images/cake.jpg',
            'dessert' => 'images/default-meals-images/dessert.jpg',
            'ott-meal' => 'images/default-meals-images/ott-meal.jpg',
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
                            ["title" => "پرتقال"]
                        ]
                    ],
                    [
                        "category" => "package",
                        "meals" => [
                            ["title" => "چیکنوا"],
                            ["title" => "چیکن رول"],
                            ["title" => "پنکیک سیب زمینی مرغ"]
                        ]
                    ],
                    [
                        "category" => "salad",
                        "meals" => [
                            ["title" => "ویتافروت سالاد"]
                        ]
                    ],
                    [
                        "category" => "sandwich",
                        "meals" => [
                            ["title" => "مرغ پستو"]
                        ]
                    ],
                    [
                        "category" => "breakfast",
                        "meals" => [
                            ["title" => "چیا تست"]
                        ]
                    ],
                    [
                        "category" => "cake",
                        "meals" => [
                            ["title" => "کیک ساده"],
                            ["title" => "کیک شکلاتی"]
                        ]
                    ]
                ]
            ],
            [
                "type" => "energy",
                "categories" => [
                    [
                        "category" => "salad",
                        "meals" => [
                            ["title" => "ماشروم پروسالاد"],
                            ["title" => "چیکن سالاد"],
                            ["title" => "سالاد ایتالیانو"],
                            ["title" => "پاستا سالاد"]
                        ]
                    ],
                    [
                        "category" => "drinks",
                        "meals" => [
                            ["title" => "شیرشکلات"],
                            ["title" => "معجون انرژی درینک"]
                        ]
                    ],
                    [
                        "category" => "package",
                        "meals" => [
                            ["title" => "چیکن ماسان"],
                            ["title" => "میت اسپاگیتو"],
                            ["title" => "مرغ و بادمجان"],
                            ["title" => "گریک رایس"]
                        ]
                    ],
                    [
                        "category" => "sandwich",
                        "meals" => [
                            ["title" => "گرین ساندویچ"],
                            ["title" => "چیز ساندویچ"]
                        ]
                    ],
                    [
                        "category" => "breakfast",
                        "meals" => [
                            ["title" => "تست فرانسوی"],
                            ["title" => "پینات تست"],
                            ["title" => "چیز تست ارده ای"]
                        ]
                    ],
                    [
                        "category" => "cake",
                        "meals" => [
                            ["title" => "کیک کماج"],
                            ["title" => "شیرمال خرما"],
                            ["title" => "آچما مغزدار"]
                        ]
                    ],
                    [
                        "category" => "dessert",
                        "meals" => [
                            ["title" => "دسر شکلاتی"],
                            ["title" => "دسر دورنگ قهوه شکلات"]
                        ]
                    ]
                ]
            ],
            [
                "type" => "diet",
                "categories" => [
                    [
                        "category" => "salad",
                        "meals" => [
                            ["title" => "سالاد سزار"],
                            ["title" => "فارما سالاد"]
                        ]
                    ],
                    [
                        "category" => "package",
                        "meals" => [
                            ["title" => "چیکی یاتوری"],
                            ["title" => "چیکن وجتبل"]
                        ]
                    ],
                    [
                        "category" => "drinks",
                        "meals" => [
                            ["title" => "رد فروت میکس"],
                            ["title" => "اسموتی نعنازنحبیل"],
                            ["title" => "بری درینک"]
                        ]
                    ],
                    [
                        "category" => "breakfast",
                        "meals" => [
                            ["title" => "اگه تست مدیترانه ای"]
                        ]
                    ],
                    [
                        "category" => "cake",
                        "meals" => [
                            ["title" => "فروت کیک"]
                        ]
                    ],
                    [
                        "category" => "dessert",
                        "meals" => [
                            ["title" => "ویتافروت میکس"]
                        ]
                    ],
                    [
                        "category" => "ott-meal",
                        "meals" => [
                            ["title" => "اوتمیل میوه ای"]
                        ]
                    ]
                ]
            ],
            [
                "type" => "caffeine",
                "categories" => [
                    [
                        "category" => "drinks",
                        "meals" => [
                            ["title" => "شیر قهوه"],
                            ["title" => "کول لته"],
                            ["title" => "آمریکانو"],
                            ["title" => "چیلی کافی"]
                        ]
                    ],
                    [
                        "category" => "cake",
                        "meals" => [
                            ["title" => "کیک قهوه"]
                        ]
                    ],
                    [
                        "category" => "dessert",
                        "meals" => [
                            ["title" => "نوشیدنی قهوه"]
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

                    // Create meal data
                    $mealsToInsert[] = [
                        'title' => $title,
                        'slug' => $slug,
                        'description' => "توضیحات {$title}",
                        'calories' => rand(150, 500),
                        'price' => rand(250000, 800000),
                        'is_vegan' => rand(0, 1) == 1,
                        'kcal' => rand(150, 500) . ' کیلو کالری',
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
