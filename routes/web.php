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
    return redirect()->route('login');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('home', 'HomeController@index')->name('home');

Route::get('profile', 'ProfileController@index')->name('profile');
Route::post('profile/save', 'ProfileController@saveProfile')->name('profile.save');
Route::post('profile/password', 'ProfileController@savePassword')->name('profile.password');

Route::get('picks', 'PicksController@index')->name('picks');
Route::get('picks/{league}', 'PicksController@league')->name('picks.league');
Route::get('picks/{league}/season/{season}', 'PicksController@season')->name('picks.season');
Route::get('picks/{league}/{race}', 'PicksController@race')->name('picks.race');
Route::post('picks/{league}/{race}', 'PicksController@create')->name('picks.create');
Route::delete('picks/{league}/{race}', 'PicksController@delete')->name('picks.delete');

Route::group([ 'prefix' => 'standings' ], function () {
	Route::get('/', 'StandingsListController@index')->name('standings');
	Route::get('{league}', 'StandingsListController@league')->name('standings.league');
	Route::get('{league}/season/{season}', 'StandingsListController@season')->name('standings.season');
	Route::get('{league}/{race}', 'StandingsListController@race')->name('standings.race');
});

Route::group([ 'prefix' => 'admin', 'middleware' => [ 'auth', 'admin' ], 'namespace' => 'Admin' ], function () {
	Route::resources([
		'series'	=> 'SeriesController',
		'seasons'	=> 'SeasonsController',
		'countries'	=> 'CountriesController',
		'circuits'	=> 'CircuitsController',
		'races'		=> 'RacesController',
		'drivers'	=> 'DriversController',
		'teams'		=> 'TeamsController',
		'entries'	=> 'EntriesController',
	]);
	
	Route::group([ 'prefix' => 'results' ], function () {
		Route::get('/', 'ResultsController@index')->name('results.index');
		Route::post('{race}', 'ResultsController@create')->name('results.create');
		Route::delete('{race}', 'ResultsController@delete')->name('results.delete');
	});
	
	Route::get('standings/{season}', 'StandingsController@recalculate')->name('standings.recalculate');
});

