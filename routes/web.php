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
if ($this->app->environment() == 'production') {
    URL::forceScheme('https');
}

Route::get('/', 'HomeController@index');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::post('import', 'FeeController@import')->name('import');
Route::post('payment', 'HomeController@success')->name('success');

