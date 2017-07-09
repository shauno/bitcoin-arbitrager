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

Route::get('/', [ 'uses' => 'PageController@homepage']);

//@TODO, this should be POST
Route::get('/arbitrage', [ 'uses' => 'ActionController@arbitrage' ]);

Route::prefix('/api/v1')->group(function() {
    Route::get('current-rates', [ 'uses' => 'CurrentRateController@index']);
});