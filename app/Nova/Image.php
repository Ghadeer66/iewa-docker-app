<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Image extends Resource
{
    public static $group = 'SITE COMPONENTS';
    public static $model = \App\Models\Image::class;
    public static $title = 'url';
    public static $search = ['id', 'url', 'alt'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('URL', 'url')->rules('required', 'max:255')->sortable(),
            Text::make('Alt')->sortable()->nullable(),
            Text::make('Extra')->hideFromIndex()->nullable(),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


