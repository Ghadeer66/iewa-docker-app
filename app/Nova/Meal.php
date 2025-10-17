<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Meal extends Resource
{
    public static $group = 'SITE COMPONENTS';
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Meal>
     */
    public static $model = \App\Models\Meal::class;

    /**
     * The value used to represent the resource.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'description',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->rules('required', 'max:255')
                ->sortable(),

            Text::make('Description')
                ->hideFromIndex(),

            Number::make('Price')
                ->step(0.01)
                ->min(0)
                ->sortable(),

            Number::make('Kcal')
                ->min(0)
                ->sortable(),

            BelongsTo::make('Type', 'type', Type::class)
                ->nullable(),

            HasOne::make('Meal Image', 'mealImage', MealImage::class),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


