<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use App\Nova\Role as RoleResource;

class Permission extends Resource
{
    public static $group = 'Permissions & Roles';
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Spatie\Permission\Models\Permission>
     */
    public static $model = \Spatie\Permission\Models\Permission::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
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

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:permissions,name')
                ->updateRules('unique:permissions,name,{{resourceId}}'),

            Text::make('Guard Name')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsToMany::make('Roles', 'roles', RoleResource::class)
                ->display('name'),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(Request $request): array
    {
        return [];
    }

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
{
    return $request->user()?->hasRole('admin') ?? false;
}

public function authorizedToUpdate(Request $request)
{
    return $request->user()?->hasRole('admin') ?? false;
}

public function authorizedToDelete(Request $request)
{
    return $request->user()?->hasRole('admin') ?? false;
}

public static function availableForNavigation(Request $request)
{
    return $request->user()?->hasRole('admin') ?? false;
}

}
