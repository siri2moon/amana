<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Amana Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where Horizon will be accessible from. If this
    | setting is null, Amana will reside under the same domain as the
    | application. Otherwise, this value will serve as the subdomain.
    |
    */

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Amana Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Amana will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */

    'path' => 'amana',

    /*
    |--------------------------------------------------------------------------
    | Amana Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will get attached onto each Horizon route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Amana Bundle ID
    |--------------------------------------------------------------------------
    |
    | Bundle id each environment for app
    |
    */
    'bundle_id' => [
        'dev'  => 'bundle_id.dev',
        'stg'  => 'bundle_id.stg',
        'prod' => 'bundle_id.prod',
    ]
];
