<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Auth\PasswordValidationRules;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Nova\Role; // 👈 Import your Nova Role resource, not Spatie’s model

class User extends Resource
{
    public static $group = 'Users';

    use PasswordValidationRules;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

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
        'id', 'name', 'email', 'phone',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Phone')
                ->sortable()
                ->rules('required', 'max:20'),

            // 👇 Use Nova Role resource, not Spatie model
            BelongsToMany::make('Roles', 'roles', Role::class)
                ->display('name'),

            // Business fields (visible only for users with permission)
            Text::make('Business Name')
                ->hideFromIndex()
                ->hideWhenCreating(fn () => !$request->user()->can('manage all users'))
                ->hideWhenUpdating(fn () => !$request->user()->can('manage all users')),

            Text::make('Business Type')
                ->hideFromIndex()
                ->hideWhenCreating(fn () => !$request->user()->can('manage all users'))
                ->hideWhenUpdating(fn () => !$request->user()->can('manage all users')),

            Text::make('Business Phone')
                ->hideFromIndex()
                ->hideWhenCreating(fn () => !$request->user()->can('manage all users'))
                ->hideWhenUpdating(fn () => !$request->user()->can('manage all users')),

            Textarea::make('Business Address')
                ->hideFromIndex()
                ->hideWhenCreating(fn () => !$request->user()->can('manage all users'))
                ->hideWhenUpdating(fn () => !$request->user()->can('manage all users')),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules($this->passwordRules())
                ->updateRules($this->optionalPasswordRules()),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [];
    }

    /**
     * Base index query so specialized user resources can override compatibly.
     */
    public static function indexQuery(NovaRequest $request, Builder $query): Builder
    {
        return $query;
    }

    /**
     * Restrict visibility in navigation to admins only.
     */
    public static function availableForNavigation(Request $request)
    {
        return $request->user()?->hasRole('admin');
    }

    /**
     * Restrict who can create new users.
     */
    public static function authorizedToCreate(Request $request)
    {
        return $request->user()?->hasRole('admin');
    }

    /**
     * Restrict who can update users.
     */
    public function authorizedToUpdate(Request $request)
    {
        return $request->user()?->hasRole('admin');
    }

    /**
     * Restrict who can delete users.
     */
    public function authorizedToDelete(Request $request)
    {
        return $request->user()?->hasRole('admin');
    }
}
