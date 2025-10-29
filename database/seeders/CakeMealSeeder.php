<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Type;
use App\Models\Category;
use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class CakeMealSeeder extends Seeder
{
    public function run(): void
    {
        // increase memory limit for image processing during seeding
        @ini_set('memory_limit', '512M');

        // ensure thumbnail directory exists
        $thumbDir = public_path('images/thumbnails');
        if (!File::exists($thumbDir)) {
            File::makeDirectory($thumbDir, 0755, true);
        }

        // Ensure category and common types exist
        $category = Category::firstOrCreate(['title' => 'cake']);
        $typeModels = collect(['energy', 'diet', 'light', 'caffeine'])
            ->mapWithKeys(fn($t) => [$t => Type::firstOrCreate(['title' => $t])]);

        // Base cakes list (some may not have images; some may have 2). Slugs used to locate images.
        $cakes = [

            [
                'title' => 'کیک شکلاتی',
                'slug' => 'chocolate-cake',
                'calories' => 380,
                'types' => ['energy'],
                'price' => 130000,
            ],
            [
                'title' => 'شیرمال خرما',
                'slug' => 'shirmaal-date',
                'calories' => 360,
                'types' => ['energy'],
                'price' => 140000,
            ],
            [
                'title' => 'کیک کماج',
                'slug' => 'kamaj-cake',
                'calories' => 340,
                'types' => ['energy'],
                'price' => 150000,
            ],
            [
                'title' => 'آچما مغزدار',
                'slug' => 'achma-nutty',
                'calories' => 370,
                'types' => ['energy'],
                'price' => 160000,
            ],
            [
                'title' => 'فروت کیک',
                'slug' => 'fruit-cake',
                'calories' => 300,
                'types' => ['diet'],
                'price' => 120000,
            ],
            [
                'title' => 'کیک وانیلی',
                'slug' => 'vanilla-cake',
                'calories' => 185,
                'types' => ['diet'],
                'nutritional_informations' => ['کربوهیدرات' => '20 گرم', 'پروتئین' => '7 گرم', 'چربی' => '9 گرم'],
                'consumable_items' => ['بعلت حضور تخم مرغ و شیر در منبع مناسبی از پروتئین و ویتامین دی می‌باشد'],
                'contraindications' => ['در افراد گلوتن فری و بیماران دیابتی مصرف نشود'],
                'price' => 110000,
            ],
            [
                'title' => 'کیک قهوه',
                'slug' => 'coffee-cake',
                'calories' => 185,
                'types' => ['caffeine'],
                'price' => 130000,
            ],
        ];

        $cakesDir = public_path('images/meals/cakes');
        $defaultImageRelative = 'images/default-meals-images/cake.jpg';

        foreach ($cakes as $data) {
            $meal = Meal::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => 'از مجموعه کیک‌ها و نان‌های سالم ایوا.',
                'calories' => $data['calories'],
                'price' => $data['price'],
                'is_vegan' => false,
                'kcal' => $data['calories'],
                'nutritional_informations' => $data['nutritional_informations'] ?? ['کربوهیدرات' => '50 گرم', 'پروتئین' => '6 گرم', 'چربی' => '10 گرم'],
                'consumable_items' => $data['consumable_items'] ?? ['منبع انرژی مناسب برای میان‌وعده.'],
                'contraindications' => $data['contraindications'] ?? ['افراد دیابتی و گلوتن فری با احتیاط مصرف کنند.'],
            ]);

            // Attach category and types
            $meal->categories()->sync([$category->id]);
            $meal->types()->sync(collect($data['types'])->map(fn($t) => $typeModels[$t]->id));

            // Discover up to two images for this cake by slug matching in cakesDir
            $attachedImageIds = [];
            if (File::exists($cakesDir) && File::isDirectory($cakesDir)) {
                $allFiles = collect(File::files($cakesDir))
                    ->filter(fn($f) => preg_match('/\.(png|jpg|jpeg|webp)$/i', $f->getFilename()))
                    ->values();

                $matched = $allFiles->filter(function ($f) use ($data) {
                    $filename = Str::lower($f->getFilename());
                    $slug = Str::lower($data['slug']);
                    return Str::contains($filename, $slug);
                })->take(2);

                foreach ($matched as $fileInfo) {
                    $relativePath = 'images/meals/cakes/' . $fileInfo->getFilename();
                    $fullImagePath = public_path($relativePath);

                    $filename = pathinfo($relativePath, PATHINFO_BASENAME);
                    $thumbnailPath = $thumbDir . '/' . $filename;
                    $thumbnailUrl = null;

                    if (File::exists($fullImagePath)) {
                        if (File::exists($thumbnailPath)) {
                            $thumbnailUrl = 'images/thumbnails/' . $filename;
                        } else {
                            $fileSizeBytes = File::size($fullImagePath);
                            if ($fileSizeBytes <= 20 * 1024 * 1024) { // 20MB
                                try {
                                    Image::read($fullImagePath)
                                        ->cover(600, 400)
                                        ->save($thumbnailPath);
                                    $thumbnailUrl = 'images/thumbnails/' . $filename;
                                } catch (\Throwable $e) {
                                    // ignore errors; proceed without thumbnail
                                }
                            }
                        }
                    }

                    $image = ImageModel::firstOrCreate(
                        ['url' => $relativePath],
                        ['thumbnail_url' => $thumbnailUrl]
                    );
                    $attachedImageIds[] = $image->id;
                }
            }

            if (!empty($attachedImageIds)) {
                $meal->images()->syncWithoutDetaching($attachedImageIds);
            } else {
                // Attach default image with thumbnail if available
                $defaultFullPath = public_path($defaultImageRelative);
                $defaultThumbUrl = null;

                if (File::exists($defaultFullPath)) {
                    $defaultFilename = pathinfo($defaultImageRelative, PATHINFO_BASENAME);
                    $defaultThumbPath = $thumbDir . '/' . $defaultFilename;

                    if (File::exists($defaultThumbPath)) {
                        $defaultThumbUrl = 'images/thumbnails/' . $defaultFilename;
                    } else {
                        $fileSizeBytes = File::size($defaultFullPath);
                        if ($fileSizeBytes <= 20 * 1024 * 1024) { // 20MB
                            try {
                                Image::read($defaultFullPath)
                                    ->cover(600, 400)
                                    ->save($defaultThumbPath);
                                $defaultThumbUrl = 'images/thumbnails/' . $defaultFilename;
                            } catch (\Throwable $e) {
                                // ignore
                            }
                        }
                    }
                }

                $defaultImage = ImageModel::firstOrCreate(
                    ['url' => $defaultImageRelative],
                    ['thumbnail_url' => $defaultThumbUrl]
                );
                $meal->images()->syncWithoutDetaching([$defaultImage->id]);
            }
        }
    }
}


