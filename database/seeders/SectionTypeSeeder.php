<?php

namespace Database\Seeders;

use App\Models\SectionType;
use App\Models\SectionElement;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionTypes = ['package', 'menu', 'problem', 'specification', 'client'];

        // Ensure section types exist
        $typeTitleToId = [];
        foreach ($sectionTypes as $typeTitle) {
            $type = SectionType::firstOrCreate(['title' => $typeTitle]);
            $typeTitleToId[$typeTitle] = $type->id;
        }

        // Define elements and their image URLs per type
        $elementsByType = [
            'package' => [
                ['title' => 'لایت', 'image' => 'storage/images/food-categories/light.png'],
                ['title' => 'رژیمی', 'image' => 'storage/images/food-categories/diet.png'],
                ['title' => 'انرژیک', 'image' => 'storage/images/food-categories/energy.png'],
                ['title' => 'کافین', 'image' => 'storage/images/food-categories/caffien.png'],
                ['title' => 'مدرسه', 'image' => 'storage/images/food-categories/school.png'],
            ],
            'menu' => [
                ['title' => 'لاین غذای اقتصادی', 'image' => 'storage/images/food-categories/eco.png'],
                ['title' => 'پک میانوعده', 'image' => 'storage/images/food-types/package.png'],
                ['title' => 'سالاد', 'image' => 'storage/images/food-types/salad.png'],
                ['title' => 'ساندویچ', 'image' => 'storage/images/food-types/sandwich.png'],
                ['title' => 'کیک و نان', 'image' => 'storage/images/food-types/cake.png'],
                ['title' => 'دمنوش و قهوه', 'image' => 'storage/images/food-types/coffee.png'],
                ['title' => 'نوشیدنی', 'image' => 'storage/images/food-types/drinks.png'],
                ['title' => 'اوتمیل', 'image' => 'storage/images/food-types/ot-meal.png'],
                ['title' => 'صبحانه', 'image' => 'storage/images/food-types/breakfast.png'],
                ['title' => 'دسیرت‌ها', 'image' => 'storage/images/food-types/dessert.png'],
            ],
            'problem' => [
                ['title' => 'چربی خون', 'image' => 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png'],
                ['title' => 'قند', 'image' => 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png'],
                ['title' => 'مشکلات ارتوپدی', 'image' => 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png'],
                ['title' => 'ذهن سالم', 'image' => 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png'],
                ['title' => 'خواب', 'image' => 'https://getjoule.co/assets/desktop/images1/diet/metabolism.png'],
            ],
            'specification' => [
                ['title' => 'افزایش آسانی بر بدن', 'image' => 'https://getjoule.co/assets/images/home_icon/3.png'],
                ['title' => 'نمود انرژی در طول روز', 'image' => 'https://getjoule.co/assets/images/home_icon/3.png'],
                ['title' => 'حفظ سلامت بلندمدت', 'image' => 'https://getjoule.co/assets/images/home_icon/3.png'],
                ['title' => 'تجربه حس شادابی', 'image' => 'https://getjoule.co/assets/images/home_icon/3.png'],
            ],
            'client' => [
                ['title' => 'Client 1', 'image' => 'http://iewato.ir/wp-content/uploads/2025/05/photo14524743455-1-e1748438251468.jpg'],
                ['title' => 'Client 2', 'image' => 'http://iewato.ir/wp-content/uploads/2025/05/%D9%84%D9%88%DA%AF%D9%88-%D8%A8%D8%A7%D9%86%DA%A9-%D8%B5%D8%A7%D8%AF%D8%B1%D8%A7%D8%AA.png'],
                ['title' => 'Client 3', 'image' => 'http://iewato.ir/wp-content/uploads/2025/05/%D8%AF%D8%A7%D9%86%D9%84%D9%88%D8%AF-%D8%B1%D8%A7%DB%8C%DA%AF%D8%A7%D9%86-%D9%84%D9%88%DA%AF%D9%88-%D8%A2%D8%B1%D9%85-%D8%A8%D8%A7%D9%86%DA%A9-%D8%B3%D9%BE%D9%87-%D8%A7%DB%8C%D8%B1%D8%A7%D9%86.png'],
                ['title' => 'Client 4', 'image' => 'http://iewato.ir/wp-content/uploads/2025/05/complexLogo-8df3-1583173540.png'],
            ],
        ];

        foreach ($elementsByType as $typeTitle => $elements) {
            $sectionTypeId = $typeTitleToId[$typeTitle] ?? null;
            if (!$sectionTypeId) {
                continue;
            }

            foreach ($elements as $element) {
                $url = $element['image'];
                $filename = pathinfo(parse_url($url, PHP_URL_PATH) ?? $url, PATHINFO_FILENAME);
                $alt = ucfirst(str_replace(['-', '_'], ' ', $filename));

                $image = Image::firstOrCreate([
                    'url' => $url,
                ], [
                    'alt' => $alt,
                    'extra' => "Extra info for {$alt}",
                ]);

                SectionElement::firstOrCreate([
                    'title' => $element['title'],
                    'section_type_id' => $sectionTypeId,
                ], [
                    'img_id' => $image->id,
                ]);
            }
        }
    }
}
