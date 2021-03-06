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

// Registration Routes...
Route::get('invite/{token}', 'Auth\RegisterController@showRegistrationForm')->name('invite');
Route::post('register', 'Auth\RegisterController@register')->name('register');

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

Route::group([ 'prefix' => 'statistics', 'as' => 'statistics.', 'namespace' => 'Statistics' ], function () {
	Route::get('season/{league?}/{season?}/{user?}', 'SeasonGraphController@index')->name('season');
	Route::get('history/{league?}', 'HistoryController@index')->name('history');
	Route::get('all-time/{league?}', 'AllTimeController@index')->name('alltime');
	Route::get('hall-of-fame/{league?}', 'FameController@index')->name('fame');
});

Route::get('rules', 'RulesPageController@index')->name('rules');

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => [ 'auth', 'admin' ], 'namespace' => 'Admin' ], function () {
	Route::resources([
		'series'	=> 'SeriesController',
		'seasons'	=> 'SeasonsController',
		'countries'	=> 'CountriesController',
		'circuits'	=> 'CircuitsController',
		'races'		=> 'RacesController',
		'drivers'	=> 'DriversController',
		'teams'		=> 'TeamsController',
		'entries'	=> 'EntriesController',
		'users'		=> 'UsersController',
		'leagues'	=> 'LeaguesController',
	]);
	
	Route::get('races/populate/{season}', 'RacesController@populate')->name('races.populate');
	Route::get('entries/populate/{season}', 'EntriesController@populate')->name('entries.populate');
	
	Route::group([ 'prefix' => 'results' ], function () {
		Route::get('/', 'ResultsController@index')->name('results.index');
		Route::post('{race}', 'ResultsController@create')->name('results.create');
		Route::delete('{race}', 'ResultsController@delete')->name('results.delete');
	});
	
	Route::get('standings/{season}', 'StandingsController@recalculate')->name('standings.recalculate');
	
	Route::group([ 'prefix' => 'userleagues' ], function () {
		Route::get('/', 'UserLeaguesController@index')->name('userleagues.index');
		Route::get('{user}', 'UserLeaguesController@edit')->name('userleagues.edit');
		Route::get('{user}/{league}/attach', 'UserLeaguesController@attach')->name('userleagues.attach');
		Route::get('{user}/{league}/detach', 'UserLeaguesController@detach')->name('userleagues.detach');
	});

	Route::group([ 'prefix' => 'picks' ], function () {
		Route::get('/', 'PicksEditController@index')->name('picks.index');
		Route::post('{race}/{user}', 'PicksEditController@create')->name('picks.create');
		Route::delete('{race}/{user}', 'PicksEditController@delete')->name('picks.delete');
	});
});
