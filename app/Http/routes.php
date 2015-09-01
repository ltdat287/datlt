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

Route::get('/', array('as' => 'home', 'uses' => 'UserController@index'));

Route::get('login', array('as' => 'login', 'uses' => 'Auth\AuthController@getLogin'));
Route::post('login', array('as' => 'login', 'uses' => 'Auth\AuthController@postLogin'));



Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);