<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AdminUser extends User
{
    public static $group = 'Users';

    public static function label(): string
    {
        return 'Admins';
    }

    public static function singularLabel(): string
    {
        return 'Admin';
    }

    public static function uriKey(): string
    {
        return 'admins';
    }

    public static function indexQuery(NovaRequest $request, Builder $query): Builder
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        });
    }

    public static function availableForNavigation(Request $request)
    {
        // Only admins should see admins list
        return $request->user()?->hasRole('admin') ?? false;
    }
}


