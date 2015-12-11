<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('search', 'ListingsController@getSearch');
Route::get('search/advanced', 'ListingsController@advancedSearch');
Route::post('search/advanced', 'ListingsController@advancedSearch');
Route::post('search', 'ListingsController@getSearch');
Route::get('users/verify/{user}/{code}', 'UsersController@verify');
Route::get('listings/', function(){
    return Redirect::to('search?q=');
});
Route::get('listings/categories/{category}', 'ListingsController@categoryListings');
Route::get('listings/countries/{country}', 'ListingsController@countryListings');
Route::get('listings/{listing}', 'ListingsController@show');
Route::get('articles/{article}', 'ArticlesController@show');
Route::get('articles/', 'ArticlesController@getSearch');
Route::get('articles/categories/{role}', 'ArticlesController@category');

Route::get('register', ['uses' => 'UsersController@register']);
Route::get('register/seller', ['uses' => 'SellersController@create']);
Route::get('register/broker', ['uses' => 'BrokersController@create']);
Route::post('register', ['uses' => 'UsersController@store']);
Route::get('login', 'UsersController@login');
Route::get('auth/facebook/{rolename?}', 'UsersController@loginWithFacebook');
Route::get('auth/google/{rolename?}', 'UsersController@loginWithGoogle');
Route::get('auth/linkedin/{rolename?}', 'UsersController@loginWithLinkedin');
Route::get('auth/yahoo/{rolename?}', 'UsersController@loginWithYahoo');
Route::get('businesses/', 'AdvertsController@getSearch');
Route::post('login', 'UsersController@authenticate');
Route::get('logout', 'UsersController@logout');
Route::get('profile/{user}', 'UsersController@profile');

Route::get('adverts/', 'AdvertsController@getSearch');
Route::get('brokers/', 'BrokersController@index');
Route::get('adverts/categories/{category}', 'ListingsController@categoryListings');
Route::get('adverts/{advert}', 'ListingsController@show');

Route::group(['prefix' => 'user'], function(){
    Route::get('login', ['as' => 'user.login', 'uses' => 'UsersController@login']);
    Route::post('login', ['as' => 'user.authenticate', 'uses' => 'UsersController@authenticate']);
    Route::get('register', ['as' => 'user.register', 'uses' => 'UsersController@register']);
    Route::post('register', ['as' => 'user.store', 'uses' => 'UsersController@store']);
});

Route::group(['prefix' => 'messages'], function(){
    Route::post('compose', 'MessagesController@store');
});

Route::group(['prefix' => 'password'], function(){
    Route::get('reset', ['uses' => 'PasswordController@remind','as' => 'password.remind']);
    Route::post('reset', ['uses' => 'PasswordController@request', 'as' => 'password.request']);
    Route::get('reset/{token}', ['uses' => 'PasswordController@reset', 'as' => 'password.reset']);
    Route::post('password/reset/{token}', ['uses' => 'PasswordController@update', 'as' => 'password.update']);
});

Route::group(['prefix' => 'sellers'], function(){
    Route::get('create', 'SellersController@create');
    Route::post('create', 'SellersController@store');
    Route::get('register', 'SellersController@create');
    Route::post('register', 'SellersController@store');
});

Route::group(['prefix' => 'broker'], function(){
    Route::get('create', 'BrokersController@create');
    Route::post('create', 'BrokersController@store');
    Route::get('register', 'BrokersController@create');
    Route::post('register', 'BrokersController@store');
});

Route::group(['before' => 'auth'], function(){
    Route::get('profile', 'UsersController@myProfile');
    Route::get('dashboard', 'UsersController@dashboard');
    Route::get('getuser', 'UsersController@getUsers');
    Route::get('account', 'UsersController@account');
    Route::post('account', 'UsersController@update');
    Route::get('sell', 'ListingsController@create');

    Route::group(['prefix' => 'admin'], function(){
        Route::get('settings', 'AdminController@settings');
        Route::get('inbox', 'MessagesController@index');
        Route::post('settings', 'AdminController@storeSettings');
        Route::get('articles', 'AdminController@listArticles');
        Route::get('articles/create', 'AdminController@createArticle');
        Route::post('articles', 'AdminController@storeArticle');
        Route::get('account', 'UsersController@account');
        Route::get('adverts', 'AdminController@adverts');
        Route::delete('adverts/delete/{advert}', 'AdminController@deleteAdvert');

        Route::group(['prefix' => 'users'], function(){
            Route::get('/', 'AdminController@getUsers');
            Route::get('/sellers', 'AdminController@sellers');
            Route::get('/brokers', 'AdminController@brokers');
            Route::get('/buyers', 'AdminController@buyers');
            Route::get('/create', 'AdminController@createUser');
            Route::post('/create', 'AdminController@storeUser');
            Route::delete('/delete/{user}', 'AdminController@deleteUser');
            Route::post('/ban/{user}', 'AdminController@banUser');
            Route::post('/unban/{user}', 'AdminController@unbanUser');
        });

        Route::group(['prefix' => 'listings'], function(){
            Route::get('/', 'AdminController@listings');
            Route::get('/seller', 'AdminController@sellerListings');
            Route::get('/broker', 'AdminController@brokerListings');
            Route::get('/adverts', 'AdminController@adverts');
            Route::post('approve/{listing}', 'AdminController@approve');
            Route::post('unapprove/{listing}', 'AdminController@unapprove');
            Route::delete('delete/{listing}', 'AdminController@destroy');
        });

        Route::group(['prefix' => 'articles'], function(){
            Route::get('/', 'AdminController@articles');
            Route::get('/create', 'AdminController@createArticle');
            Route::post('/create', 'AdminController@storeArticle');
            Route::get('/edit/{article}', 'AdminController@editArticle');
            Route::post('/edit/{article}', 'AdminController@updateArticle');
            Route::delete('/delete/{article}', 'AdminController@deleteArticle');
        });
    });

    Route::group(['prefix' => 'inbox'], function(){
        Route::get('compose', 'MessagesController@create');
        Route::get('compose/{user}', 'MessagesController@createForUser');
        Route::post('compose', 'MessagesController@store');
        Route::post('reply/{message}', 'MessagesController@reply');
        Route::delete('delete/{message}/{ajax?}', 'MessagesController@destroy');
        Route::get('/', 'MessagesController@index');
        Route::get('{id}', 'MessagesController@read');
    });

    Route::group(['prefix' => 'sellers'], function(){
        Route::get('listings', 'ListingsController@index');
        Route::get('inbox', 'MessagesController@index');
        Route::get('listings/pending', 'ListingsController@pending');
        Route::get('listings/approved', 'ListingsController@approved');
        Route::get('listings/create', 'ListingsController@create');
        Route::post('listings/create', 'ListingsController@store');
        Route::get('listings/edit/{listing}', 'ListingsController@edit');
        Route::post('listings/{listing}/photos', 'ListingsController@addPhotos');
        Route::post('listings/update/{listing}', 'ListingsController@update');
        Route::post('listings/edit/{listing}', 'ListingsController@update');
        Route::get('listings/preview/{listing}', 'ListingsController@preview');
        Route::delete('listings/delete/{listing}', 'ListingsController@delete');
        Route::get('listings/{listing}', 'ListingsController@show');
    });

    Route::group(['prefix' => 'seller'], function(){
        Route::get('listings', 'ListingsController@index');
        Route::get('inbox', 'MessagesController@index');
        Route::get('listings/pending', 'ListingsController@pending');
        Route::get('listings/approved', 'ListingsController@approved');
        Route::get('listings/create', 'ListingsController@create');
        Route::post('listings/create', 'ListingsController@store');
        Route::get('listings/edit/{listing}', 'ListingsController@edit');
        Route::post('listings/{listing}/photos', 'ListingsController@addPhotos');
        Route::post('listings/update/{listing}', 'ListingsController@update');
        Route::post('listings/edit/{listing}', 'ListingsController@update');
        Route::get('listings/preview/{listing}', 'ListingsController@preview');
        Route::delete('listings/delete/{listing}', 'ListingsController@delete');
        Route::get('listings/{listing}', 'ListingsController@show');
    });

    Route::group(['prefix' => 'buyers'], function(){
        Route::get('adverts', 'AdvertsController@index');
        Route::get('adverts/pending', 'AdvertsController@pending');
        Route::get('adverts/create', 'AdvertsController@create');
        Route::post('adverts/create', 'AdvertsController@store');
        Route::get('adverts/edit/{advert}', 'AdvertsController@edit');
        Route::post('adverts/update/{advert}', 'AdvertsController@update');
        Route::post('adverts/edit/{advert}', 'AdvertsController@update');
        Route::get('adverts/preview/{advert}', 'AdvertsController@preview');
        Route::delete('adverts/delete/{advert}', 'AdvertsController@delete');
        Route::get('adverts/{advert}', 'AdvertsController@show');
    });

    Route::group(['prefix' => 'buyer'], function(){
        Route::get('adverts', 'AdvertsController@index');
        Route::get('adverts/pending', 'AdvertsController@pending');
        Route::get('adverts/create', 'AdvertsController@create');
        Route::get('feature', 'AdvertsController@create');
        Route::post('adverts/create', 'AdvertsController@store');
        Route::post('feature', 'AdvertsController@store');
        Route::get('adverts/edit/{advert}', 'AdvertsController@edit');
        Route::post('adverts/edit/{advert}', 'AdvertsController@update');
        Route::post('adverts/update/{advert}', 'AdvertsController@update');
        Route::get('adverts/preview/{advert}', 'AdvertsController@preview');
        Route::delete('adverts/delete/{advert}', 'AdvertsController@delete');
        Route::get('adverts/{advert}', 'AdvertsController@show');
    });

    Route::group(['prefix' => 'brokers'], function(){
        Route::get('listings', 'ListingsController@index');
        Route::get('inbox', 'MessagesController@index');
        Route::get('listings/pending', 'ListingsController@pending');
        Route::get('listings/approved', 'ListingsController@approved');
        Route::get('listings/create', 'ListingsController@create');
        Route::post('listings/create', 'ListingsController@store');
        Route::get('listings/edit/{listing}', 'ListingsController@edit');
        Route::post('listings/{listing}/photos', 'ListingsController@addPhotos');
        Route::post('listings/update/{listing}', 'ListingsController@update');
        Route::get('listings/preview/{listing}', 'ListingsController@preview');
        Route::delete('listings/delete/{listing}', 'ListingsController@delete');
        Route::get('listings/{listing}', 'ListingsController@show');
    });

    Route::group(['prefix' => 'broker'], function(){
        Route::get('listings', 'ListingsController@index');
        Route::get('inbox', 'MessagesController@index');
        Route::get('listings/pending', 'ListingsController@pending');
        Route::get('listings/approved', 'ListingsController@approved');
        Route::get('listings/create', 'ListingsController@create');
        Route::post('listings/create', 'ListingsController@store');
        Route::get('listings/edit/{listing}', 'ListingsController@edit');
        Route::post('listings/{listing}/photos', 'ListingsController@addPhotos');
        Route::post('listings/update/{listing}', 'ListingsController@update');
        Route::get('listings/preview/{listing}', 'ListingsController@preview');
        Route::delete('listings/delete/{listing}', 'ListingsController@delete');
        Route::get('listings/{listing}', 'ListingsController@show');
    });

    Route::get('log', 'Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::post('contact', ['as' => 'site.contact', 'uses' => 'HomeController@contact', 'before' => 'csrf', function(){
    return 'You gave a valid CSRF token!';
}]);

Route::model('user', 'User');
Route::model('buyer', 'App\Models\Buyer');
Route::model('role', 'App\Models\Role');
Route::model('category', 'App\Models\Category');
Route::model('country', 'App\Models\Country');
Route::model('listing', 'App\Models\Listing');
Route::model('article', 'App\Models\Article');
Route::model('advert', 'App\Models\Advert');
Route::model('seller', 'App\Models\Seller');
Route::model('message', 'App\Models\Message');