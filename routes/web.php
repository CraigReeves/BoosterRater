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
    return view('home');
});

Route::group(['middleware' => ['web']], function () {

    Route::post('/ratings', ['uses' => 'RatingsController@createNew', 'as' => 'create_rating']);

    Route::get('/fundraisers', ['uses' => 'FundRaisersController@index', 'as' => 'get_fundraisers']);

    Route::get('/fundraisers/show', ['uses' => 'FundRaisersController@show', 'as' => 'fundraiser']);
});