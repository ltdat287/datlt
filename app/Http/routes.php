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

Route::get('login', array('as' => 'login', 'uses' => 'Auth\AuthController@getLogin'));
Route::post('login', array('as' => 'login', 'uses' => 'Auth\AuthController@postLogin'));

// Check login before enter address
Route::group(['middleware' => 'auth'], function() {
	Route::get('/', array('as' => 'home', 'uses' => 'UserController@index'));
	Route::get('logout', array('as' => 'logout', 'uses' => 'Auth\AuthController@getLogout'));
	Route::get('search',    array('as' => 'search', 'uses' => 'UserController@search'));
	Route::get('add',       array('as' => 'add', 'uses' => 'UserController@create'));
    Route::post('add/conf', array('as' => 'add_conf', 'uses' => 'UserController@add_conf'));
    Route::post('add/comp', array('as' => 'add_comp', 'uses' => 'UserController@store'));
});



Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);