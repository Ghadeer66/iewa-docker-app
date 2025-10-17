<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;

class OrderItem extends Resource
{
    public static $group = 'SITE COMPONENTS';
    public static $model = \App\Models\OrderItem::class;
    public static $title = 'id';
    public static $search = ['id'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Order', 'order', Order::class),
            BelongsTo::make('Meal', 'meal', Meal::class)->nullable(),
            Number::make('Quantity')->min(1)->step(1),
            Number::make('Price')->step(0.01)->min(0),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


