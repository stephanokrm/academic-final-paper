<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index', function() {
	return redirect()->route('home.index');
});

Route::get('login', ['as' => 'auth.index', 'uses' => 'Auth\AuthController@index']);
Route::post('logar', ['as' => 'auth.ldap', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
});
