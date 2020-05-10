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
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/comment', 'CommentController@store')->name('comment.store')->middleware('auth');
Route::get('/book/{book}', 'BookController@show')->name('book')->middleware('auth');

Route::post('/bookrate', 'BookRateController@store')->name('bookrate.store')->middleware('auth');
