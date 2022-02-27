<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


Route::post('/forgot-password', 'ForgotPasswordController@forgotPassword');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::post('/reset-password', 'ForgotPasswordController@resetPassword');


Route::get('/', function () {
    return view('pages.home');
});

/*
*   BLOG ROUTES
*/
Route::get('blog', 'BlogController@index');
Route::post('blog', 'BlogController@create');

//blog categories
Route::get('blog/categories/{activeCategories}', 'BlogCategoryController@show');

//blog post
Route::get('blog/{id}', 'BlogController@show')->where('id', '[0-9]+');
Route::put('blog/{id}', 'BlogController@update')->where('id', '[0-9]+');
Route::get('blog/{id}/edit', 'BlogController@edit')->where('id', '[0-9]+');
Route::delete('blog/{id}', 'BlogController@destroy')->where('id', '[0-9]+');

//blog comments
Route::post('blog/comment/', 'CommentController@create');
Route::put('blog/comment/', 'CommentController@update');
Route::delete('blog/comment/', 'CommentController@destroy');

//blog crud
Route::get('blog_post_crud', 'BlogCategoryController@create');

/*
*
*/
Route::get('events', 'EventsController@index');
Route::post('event', 'EventsController@create');

Route::get('all_events', 'EventsController@allIndex');
Route::get('event_post_crud', 'EventsController@form');
Route::get('all_events/{id}', 'EventsController@showFromCategory')->where('id', '[0-9]+');
Route::get('event/{id}', 'EventsController@show')->where('id', '[0-9]+');
Route::put('event/{id}', 'EventsController@update')->where('id', '[0-9]+');
Route::get('event/{id}/edit', 'EventsController@edit')->where('id', '[0-9]+');
Route::delete('event/{id}', 'EventsController@destroy')->where('id', '[0-9]+');

Route::post('order/{id}', 'OrderController@create');
Route::get('api/events/{time}', 'EventsController@filterEvents');

Route::get('market', 'MarketController@index');
Route::post('market', 'MarketController@create');
Route::get('market/{id}', 'MarketController@show')->where('id', '[0-9]+');
Route::get('vendor_crud', 'MarketController@form');
Route::put('market/{id}', 'MarketController@update')->where('id', '[0-9]+');
Route::get('market/{id}/edit', 'MarketController@edit')->where('id', '[0-9]+');
Route::delete('market/{id}', 'MarketController@destroy')->where('id', '[0-9]+');

Route::get('admin', 'AdminController@index');
//Route::get('user/{id}', 'UserController@show')->where('id', '[0-9]+');
Route::get('user', 'UserController@showOwnProfile');
Route::post('user', 'UserController@store');
Route::put('user', 'UserController@update');
Route::patch('user', 'UserController@inactivate');


Route::get('searchUsers', 'SearchController@searchUsers')->name('searchUsers');
Route::get('search', 'SearchController@search')->name('search');



Route::get('api/locations/{district}', 'EventsController@getCounties');
Route::get('api/locations/{district}/{county}', 'EventsController@getParishes');


//verify
Route::put('admin/user/delete', 'AdminController@inactivate');
Route::put('admin/user/changeRole', 'AdminController@update');
