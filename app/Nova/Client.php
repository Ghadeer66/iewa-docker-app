<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Client extends User
{
    public static $group = 'Users';

    public static function label(): string
    {
        return 'Clients';
    }

    public static function singularLabel(): string
    {
        return 'Client';
    }

    public static function uriKey(): string
    {
        return 'clients';
    }

    /**
     * Show only users with the client role.
     */
    public static function indexQuery(NovaRequest $request, Builder $query): Builder
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'client');
        });
    }

    public static function availableForNavigation(Request $request)
    {
        // Visible to admins; adjust if business users should see this too
        return $request->user()?->hasRole('admin') ?? false;
    }
}


