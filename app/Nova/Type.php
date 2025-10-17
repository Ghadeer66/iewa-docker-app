<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Type extends Resource
{
    public static $group = 'SITE COMPONENTS';
    public static $model = \App\Models\Type::class;
    public static $title = 'title';
    public static $search = ['id', 'title'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->rules('required', 'max:255')->sortable(),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


