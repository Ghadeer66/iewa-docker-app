<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BusinessUser extends User
{
    public static $group = 'Users';

    public static function label(): string
    {
        return 'Business Users';
    }

    public static function singularLabel(): string
    {
        return 'Business User';
    }

    public static function uriKey(): string
    {
        return 'business-users';
    }

    public static function indexQuery(NovaRequest $request, Builder $query): Builder
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'business');
        });
    }

    public static function availableForNavigation(Request $request)
    {
        // Visible to admins; adjust if business managers should see this too
        return $request->user()?->hasRole('admin') ?? false;
    }
}


