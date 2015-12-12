<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| Admin Filter
|--------------------------------------------------------------------------
|
| The "admin" filter ensures a user is an admin to access admin routes.
|
*/

Route::filter('admin', function()
{
    if(Auth::check() && !Auth::user()->isAdmin())
    {
        return View::make('errors.404')->withMessage("The page you're trying to access does not exist or you do not have the correct permissions to access");
    }
});

/*
|--------------------------------------------------------------------------
| Seller Filter
|--------------------------------------------------------------------------
|
| The "seller" filter ensures a user is an admin to access admin routes.
|
*/

Route::filter('seller', function()
{
    if(Auth::check() && !Auth::user()->isSeller())
    {
        return View::make('errors.404')->withMessage("The page you're trying to access does not exist or you do not have the correct permissions to access");
    }
});

/*
|--------------------------------------------------------------------------
| Broker Filter
|--------------------------------------------------------------------------
|
| The "broker" filter ensures a user is an admin to access admin routes.
|
*/

Route::filter('broker', function()
{
    if(Auth::check() && !Auth::user()->isBroker())
    {
        return View::make('errors.404')->withMessage("The page you're trying to access does not exist or you do not have the correct permissions to access");
    }
});

/*
|--------------------------------------------------------------------------
| Buyer Filter
|--------------------------------------------------------------------------
|
| The "buyer" filter ensures a user is an admin to access admin routes.
|
*/

Route::filter('buyer', function()
{
    if(Auth::check() && !Auth::user()->isBuyer())
    {
        return View::make('errors.404')->withMessage("The page you're trying to access does not exist or you do not have the correct permissions to access");
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
        Log::info('csrf_token_gate -- IP: '.$_SERVER['REMOTE_ADDR']);
        App::abort(403, 'Invalid request. Please try again');
	}
});
