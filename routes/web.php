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

//$stripe;
//App::singleton('App\Services\Redis',function (){


//$stripe = App::make('App\Services\Redis');
//$stripe = resolve('App\Services\Redis');
//$stripe = app('App\Services\Redis');
//dd($stripe);

Route::get('/', function () {
    return view('welcome');
});
//Route::resource('tasks', 'TaskController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
