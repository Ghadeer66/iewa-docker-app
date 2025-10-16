<?php

namespace Database\Seeders;

use App\Models\SectionType;
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

        foreach ($sectionTypes as $type) {
            SectionType::create([
                'title' => $type,
            ]);
        }
    }
}
