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
    return view('site.layout');
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
    Route::get('/category/active-category','CategoryController@activeCategory');




    # post Controller
    Route::post('/post/remove-posts', 'PostController@removesPosts');
    Route::post('/post/status-change', 'PostController@statusChange');
    Route::get('/post/posts-search', 'PostController@searchContent');
    Route::get('/post/show/{slug}', 'PostController@show');
    Route::get('/post/algosearch/{searchKey}', 'PostController@seachAlgolia');

    Route::resource('/post','PostController');
});

/* for front End */
Route::namespace('Admin')->group(function () {

    Route::get('/category/active-top-category', 'CategoryController@activeTopCategory');

    /*Post Controller*/

    Route::resource('/post','PostController');
});
Route::resource('/votes', 'VoteController');

Route::get('/{vue_capture?}', 'HomeController@index')
    ->where('vue_capture', '^(?!vue_capture).*$')
    ->name('home');

