<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Ingredient extends Resource
{
    public static $group = 'SITE COMPONENTS';
    public static $model = \App\Models\Ingredient::class;
    public static $title = 'id';
    public static $search = ['id'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->nullable(),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


