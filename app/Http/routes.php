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
Route::group(['middleware' => ['validation']], function() {

    Route::get('/', function() {
        return redirect()->route('home.index');
    });

    Route::get('login', ['as' => 'auth.index', 'uses' => 'Auth\AuthController@index']);
    Route::post('logar', ['as' => 'auth.ldap', 'uses' => 'Auth\AuthController@login']);
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

    Route::get('usuarios/criar', ['as' => 'users.create', 'uses' => 'UserController@create']);
    Route::post('usuarios', ['as' => 'users.store', 'uses' => 'UserController@store']);
    Route::get('usuarios/{id}/editar', ['as' => 'users.edit', 'uses' => 'UserController@edit']);
    Route::patch('usuarios/{id}', ['as' => 'users.update', 'uses' => 'UserController@update']);

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);

        Route::get('usuarios', ['as' => 'users.index', 'uses' => 'UserController@index']);
        Route::get('usuarios/{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);
        Route::delete('usuarios/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);

        Route::group(['middleware' => 'google'], function() {
            Route::get('google/sair', ['as' => 'google.logout', 'uses' => 'GoogleController@logout']);

            Route::get('turmas/{id}/calendarios', ['as' => 'calendars.index', 'uses' => 'CalendarController@index']);
            Route::get('turmas/{id}/calendarios/criar', ['as' => 'calendars.create', 'uses' => 'CalendarController@create']);
            Route::post('turmas/{id}/calendarios', ['as' => 'calendars.store', 'uses' => 'CalendarController@store']);
            Route::get('calendarios/{id}', ['as' => 'calendars.show', 'uses' => 'CalendarController@show']);
            Route::get('calendarios/{id}/editar', ['as' => 'calendars.edit', 'uses' => 'CalendarController@edit']);
            Route::patch('calendarios/{id}', ['as' => 'calendars.update', 'uses' => 'CalendarController@update']);
            Route::post('calendarios/deletar', ['as' => 'calendars.destroy', 'uses' => 'CalendarController@destroy']);

            Route::get('calendarios/{id}/eventos', ['as' => 'events.index', 'uses' => 'EventController@index']);
            Route::get('calendarios/{id}/eventos/criar', ['as' => 'events.create', 'uses' => 'EventController@create']);
            Route::post('eventos', ['as' => 'events.store', 'uses' => 'EventController@store']);
            Route::get('calendarios/{calendar}/eventos/{id}', ['as' => 'events.show', 'uses' => 'EventController@show']);
            Route::get('calendarios/{calendar}/eventos/{id}/editar', ['as' => 'events.edit', 'uses' => 'EventController@edit']);
            Route::patch('calendarios/{calendar}/eventos/{id}', ['as' => 'events.update', 'uses' => 'EventController@update']);
            Route::delete('eventos/{id}', ['as' => 'events.destroy', 'uses' => 'EventController@destroy']);

            Route::get('turmas/{id}/atividades', ['as' => 'activities.index', 'uses' => 'ActivityController@index']);
            Route::get('atividades/{id}', ['as' => 'activities.show', 'uses' => 'ActivityController@show']);

            Route::group(['middleware' => 'teacher'], function() {
                Route::get('turmas/{id}/atividades/criar', ['as' => 'activities.create', 'uses' => 'ActivityController@create']);
                Route::post('turmas/{id}/atividades', ['as' => 'activities.store', 'uses' => 'ActivityController@store']);
                Route::get('atividades/{id}/editar', ['as' => 'activities.edit', 'uses' => 'ActivityController@edit']);
                Route::patch('atividades/{id}', ['as' => 'activities.update', 'uses' => 'ActivityController@update']);
                Route::post('atividades/deletar', ['as' => 'activities.destroy', 'uses' => 'ActivityController@destroy']);
            });
        });
    });
});
