<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

    app_path().'/commands',
    app_path().'/controllers',
    app_path().'/models',
    app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

// Handling error for not allowed method
App::error(function(\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e) {
    Log::error("Method not allowed");
    $uri = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : null;
    if ($uri){
        Log::error("SCRIPT_URI: " . $uri);
        Log::error("METHOD:".$_SERVER['REQUEST_METHOD']);
    }
    Log::error($e);
    $code =  $e->getCode() ?  $e->getCode() : 500;
    if(!App::environment('local'))
    {
        return Response::make('Method not allowed');
    }
});

// Handling error for not allowed method
App::error(function(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
    Log::error("Route not found");
    $uri = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : null;
    if ($uri){
        Log::error("SCRIPT_URI: " . $uri);
        Log::error("METHOD:".$_SERVER['REQUEST_METHOD']);
    }
    Log::error($e);
    $code =  $e->getCode() ?  $e->getCode() : 500;
    if(!App::environment('local'))
    {
        return View::make('errors.404');
    }
});

// Handling error for not allowed method
App::error(function(\Exception $e) {
    Log::error("Route not found");
    $uri = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : null;
    if ($uri){
        Log::error("SCRIPT_URI: " . $uri);
        Log::error("METHOD:".$_SERVER['REQUEST_METHOD']);
    }
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
    if ($uri){
        Log::error("REQUEST_URI: " . parse_url($uri, PHP_URL_PATH));
        Log::error("METHOD:".$_SERVER['REQUEST_METHOD']);
    }
    Log::error($e);
    $code =  $e->getCode() ?  $e->getCode() : 500;
    if(!App::environment('local'))
    {
        return View::make('errors.500');
    }
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
          {
              return Response::make("Be right back!", 503);
          });

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
