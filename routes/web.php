<?php

use Illuminate\Support\Facades\Route;

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
    return view('/auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/
Route::resource('/admin', AdminController::class);
 Route::post('/admin', 'AdminController@update');
 

Route::resource('/user', UserController::class);
Route::post('/user/edit', ['as' => 'user.update', 'uses' => 'UserController@update']);
Route::post('/user', 'UserController@store');
