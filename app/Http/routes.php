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


Route::auth();
Route::get('/', 'HomeController@index');

Route::get('request/', ['as' => 'request', 'uses' => 'RequestController@index']);
Route::post('request/store', ['as' => 'request.store', 'uses' => 'RequestController@store']);
Route::post('request/process', ['as' => 'request.process', 'uses' => 'RequestController@process']);
Route::get('request/show/{id}', ['as' => 'request.show', 'uses' => 'RequestController@show']);
Route::patch('request/update/{id}', ['as' => 'request.update', 'uses' => 'RequestController@update']);
Route::get('request/delete/{id}', ['as' => 'request.destroy', 'uses' => 'RequestController@destroy']);
Route::get('request/edit/{id}', ['as' => 'request.edit', 'uses' => 'RequestController@edit']);


Route::group(['middleware' => 'dispatch'], function () {
    Route::get('dispatch/', ['as' => 'request.dispatch', 'uses' => 'RequestController@sender']);
    Route::get('distpatch/delivered/{id}', ['as' => 'request.delivered', 'uses' => 'RequestController@delivered']);
});
Route::group(['middleware' => 'admin'], function () {
    Route::get('users', ['as' => 'users', 'uses' => 'HomeController@users']);
    Route::get('users/create', ['as' => 'user.create', 'uses' => 'HomeController@create']);
    Route::post('users/register', ['as' => 'user.register', 'uses' => 'HomeController@register']);
    Route::get('users/show/{id}', ['as' => 'user.show', 'uses' => 'UserController@show']);
    Route::get('users/edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
    Route::post('users/edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
});