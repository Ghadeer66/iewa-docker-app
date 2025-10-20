<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Entrypoints
    |--------------------------------------------------------------------------
    |
    | Define which files Vite should load. Usually, this matches what you
    | specify in vite.config.ts under `laravel({ input: [...] })`.
    |
    */

    'entry_points' => [
        'resources/js/app.ts',
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Server
    |--------------------------------------------------------------------------
    |
    | The URL of your local Vite dev server. Laravel uses this to serve assets
    | during development.
    |
    */

    'dev_server' => [
        'url' => env('VITE_DEV_SERVER_URL', 'http://localhost:5173'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Build Path
    |--------------------------------------------------------------------------
    |
    | The path where Laravel looks for the Vite manifest. Since your build
    | output lives inside `public/build/.vite/manifest.json`, we point Laravel
    | directly there.
    |
    */

    'build_path' => public_path('build/.vite'),

];
