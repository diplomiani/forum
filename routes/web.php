<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//home Controller
Route::get('/home', 'HomeController@index')->name('home');

//threads controller
Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::post('/threads', 'ThreadsController@store')->name('threads.store');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy')->name('threads.destroy');

//Replies Controller
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('replies.index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

// subscriptions
Route::post('/threads/{channel}/{thread}/subscriptions', 'SubscriptionsController@store')
	->name('subscriptions.store')
	->middleware('auth');

Route::delete('/threads/{channel}/{thread}/subscriptions', 'SubscriptionsController@destroy')
	->name('subscriptions.destroy')
	->middleware('auth');


//Favorite Controller
Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('favorite.store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy')->name('favorite.destroy');

//Profile Controller
Route::get('profiles/{user}', 'ProfilesController@show')->name('profiles.show');
Route::get('profiles/{user}/notifications', 'UsersNotificationsController@index')->name('notification.index');
Route::delete('profiles/{user}/notifications/{notification}', 'UsersNotificationsController@destroy')->name('notification.destroy');



