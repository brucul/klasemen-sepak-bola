<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', 'DashboardController@index')->name('index');

Route::group(['prefix' => 'club'], function() {
    Route::get('/', 'ClubController@index')->name('club.index');
    Route::get('/json', 'ClubController@json')->name('club.json');
    Route::post('/store', 'ClubController@store')->name('club.store');
});

Route::group(['prefix' => 'match'], function() {
    Route::get('/', 'MatchController@index')->name('match.index');
    Route::get('/json', 'MatchController@json')->name('match.json');
    Route::post('/store', 'MatchController@store')->name('match.store');
    Route::post('/store-multi', 'MatchController@storeMultiple')->name('match.store-multi');
    Route::post('/get-club-2', 'MatchController@getClub2')->name('match.get-club-2');
});

Route::group(['prefix' => 'standings'], function() {
    Route::get('/', 'StandingController@index')->name('standings.index');
    Route::get('/json', 'StandingController@json')->name('standings.json');
});