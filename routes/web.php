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

Route::get('/', function () {
    return view('index');
});

Route::post('/authenticate', ['as' => 'users.authenticate', 'uses' => 'UserController@authenticate']);
Route::get('/logout', ['as' => 'users.logout', 'uses' => 'UserController@logout']);
Route::get('/create-auth-url', ['as' => 'googles.createAuthUrl', 'uses' => 'GoogleController@createAuthUrl']);
Route::get('/google-authenticate', ['as' => 'googles.authenticate', 'uses' => 'GoogleController@authenticate']);
Route::get('/google-logout', ['as' => 'googles.logout', 'uses' => 'GoogleController@logout']);
Route::get('/users-by-team', ['as' => 'users.byTeam', 'uses' => 'UserController@usersByTeam']);
Route::get('/calendars/{id}/attendees', ['as' => 'calendars.attendees', 'uses' => 'CalendarController@attendees']);
Route::get('/calendars/{id}/not-attendees', ['as' => 'calendars.notAttendees', 'uses' => 'CalendarController@notAttendees']);
Route::post('/calendars/add-attendee', ['as' => 'calendars.addAttendee', 'uses' => 'CalendarController@addAttendee']);
Route::post('/calendars/remove-attendee', ['as' => 'calendars.removeAttendee', 'uses' => 'CalendarController@removeAttendee']);
Route::post('/all-events', ['as' => 'events.index', 'uses' => 'EventController@index']);
Route::post('/events/{id}/destroy', ['as' => 'events.destroy', 'uses' => 'EventController@destroy']);
Route::post('/atividades/{id}/detalhes-aluno', ['as' => 'activities.details', 'uses' => 'ActivityController@details']);
Route::get('/turma/{team}/atividades', ['as' => 'activities.index', 'uses' => 'ActivityController@index']);
Route::get('/aluno/atividades', ['as' => 'activities.fromStudent', 'uses' => 'ActivityController@fromStudent']);

Route::resource('users', 'UserController');
Route::resource('teams', 'TeamController');
Route::resource('calendars', 'CalendarController');
Route::resource('activities', 'ActivityController', ['except' => ['index']]);
Route::resource('colors', 'ColorController');
Route::resource('events', 'EventController', ['except' => ['index', 'destroy']]);
