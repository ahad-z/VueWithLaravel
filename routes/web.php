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



Route::namespace('Admin')->group(function () {
    Route::get('/category', 'CategoryController@index');
    Route::post('/add-category','CategoryController@store')->name('add.category');
    Route::get('/category-delete/{categorySlug}','CategoryController@destroy');
    Route::get('/category-show/{slug}','CategoryController@show');
    Route::post('/category-update/{slug}','CategoryController@update');
    Route::post('/categories/removes-items','CategoryController@removesCategory');
    Route::post('/categories/change-status','CategoryController@changeStatus');


    # post Controller
    Route::post('/post/remove-posts', 'PostController@removesPosts');
    Route::post('/post/status-change', 'PostController@statusChange');
    Route::resource('/post','PostController');


});
Route::get('/{anypath}', 'HomeController@index')->where('anypath', '.*');



