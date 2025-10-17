<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Order extends Resource
{
    public static $group = 'SITE COMPONENTS';
    public static $model = \App\Models\Order::class;
    public static $title = 'id';
    public static $search = ['id'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Status')->nullable(),
            HasMany::make('Order Items', 'orderItems', OrderItem::class),
        ];
    }

    public function cards(Request $request): array { return []; }
    public function filters(Request $request): array { return []; }
    public function lenses(Request $request): array { return []; }
    public function actions(Request $request): array { return []; }
}


