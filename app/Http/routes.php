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

Route::get('/', function() {
    return redirect()->route('home.index');
});

Route::get('login', ['as' => 'auth.index', 'uses' => 'Auth\AuthController@index']);
Route::post('logar', ['as' => 'auth.ldap', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('home', ['as' => 'home.index', 'uses' => 'HomeController@index']);

    Route::group(['middleware' => 'google'], function() {
        Route::get('google/sair', ['as' => 'google.logout', 'uses' => 'GoogleController@logout']);

        Route::get('calendarios', ['as' => 'calendars.index', 'uses' => 'CalendarController@index']);
        Route::get('calendarios/criar', ['as' => 'calendars.create', 'uses' => 'CalendarController@create']);
        Route::post('calendarios', ['as' => 'calendars.store', 'uses' => 'CalendarController@store']);
        Route::get('calendarios/{id}', ['as' => 'calendars.show', 'uses' => 'CalendarController@show']);
        Route::get('calendarios/{id}/editar', ['as' => 'calendars.edit', 'uses' => 'CalendarController@edit']);
        Route::patch('calendarios/{id}', ['as' => 'calendars.update', 'uses' => 'CalendarController@update']);
        Route::delete('calendarios/{id}', ['as' => 'calendars.destroy', 'uses' => 'CalendarController@destroy']);
    });
});
