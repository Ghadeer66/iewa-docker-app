<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'storage/images/food-categories/light.png',
            'storage/images/food-categories/diet.png',
            'storage/images/food-categories/energy.png',
            'storage/images/food-categories/caffien.png',
            'storage/images/food-categories/school.png',
        ];

        foreach ($categories as $url) {
            // Generate a title/alt based on the filename
            $filename = pathinfo($url, PATHINFO_FILENAME); // e.g., "light"
            $alt = ucfirst(str_replace('-', ' ', $filename)); // e.g., "Light"

            Image::create([
                'url' => $url,
                'alt' => $alt,
                'extra' => "Extra info for {$alt}", // You can customize this
            ]);
        }
    }
}
