<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class SectionElement extends Resource
{
    public static $group = 'SITE COMPONENTS';

    public static $model = \App\Models\SectionElement::class;
    public static $title = 'id';
    public static $search = ['id'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->nullable(),
            BelongsTo::make('Image', 'sectionElementImage', Image::class)->nullable(),
            BelongsTo::make('Section Type', 'sectionType', SectionType::class)
                ->display('title')
                ->nullable(),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


