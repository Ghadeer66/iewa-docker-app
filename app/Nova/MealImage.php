<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;

class MealImage extends Resource
{
    public static $group = 'SITE COMPONENTS';
    public static $model = \App\Models\MealImage::class;
    public static $title = 'id';
    public static $search = ['id'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Meal', 'meal', Meal::class),
            BelongsTo::make('Image', 'image', Image::class),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


