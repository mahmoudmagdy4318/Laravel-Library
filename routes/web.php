<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
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

Route::get('/bookslist', function () {
    return view('react');
});


Auth::routes();

// Books & Comments & Rates Routes
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/comment', 'CommentController@store')->name('comment.store')->middleware('auth');
Route::get('/book/{book}', 'BookController@show')->name('book')->middleware('auth');

Route::post('/bookrate', 'BookRateController@store')->name('bookrate.store')->middleware('auth');
Route::post('/commentrate', 'CommentRateController@store')->name('commentrate.store')->middleware('auth');
Route::get('/books', 'BookController@index')->name('book.index')->middleware('auth');
// ========================================

Route::middleware([Admin::class, "auth"])->group(function () {
    Route::resource('admins', 'AdminController');
    Route::resource('users', 'UserController');

    //admin books routes
    Route::get('/admin/books', 'AdminBooksController@index')->name('admin.books');
    Route::post('/admin/books', 'AdminBooksController@store')->name('admin.books.store');
    Route::put('/admin/books/{book}', 'AdminBooksController@update')->name('admin.books.update');
    Route::get('/admin/{book}/books', 'AdminBooksController@edit')->name('admin.books.edit');
    Route::get('/admin/books/create', 'AdminBooksController@create')->name('admin.books.create');
    Route::delete('/admin/books/{book}', 'AdminBooksController@destroy')->name('admin.books.destroy');

    //admin categories routes
    Route::get('/admin/categories', 'AdminCategoriesController@index')->name('admin.categories');
    Route::post('/admin/categories', 'AdminCategoriesController@store')->name('admin.categories.store');
    Route::put('/admin/categories/{category}', 'AdminCategoriesController@update')->name('admin.categories.update');
    Route::get('/admin/{category}/categories', 'AdminCategoriesController@edit')->name('admin.categories.edit');
    Route::get('/admin/categories/create', 'AdminCategoriesController@create')->name('admin.categories.create');
    Route::delete('/admin/categories/{category}', 'AdminCategoriesController@destroy')->name('admin.categories.destroy');


    Route::get('/home/admin', 'AdminController@home')->name('admin.home');
});
Route::resource('categories', 'CategoryController');
Route::resource('favouritebooks', 'FavouriteBooksController')->only([
'index','store', 'destroy'
])->middleware('auth');
Route::resource('leasedBooks', 'LeasesBooksController')->only([
    'index', 'store'
])->middleware('auth');
Route::get('/myfavourites', function () {
    return view('favourite');
});
