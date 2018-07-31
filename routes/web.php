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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth']);

Route::resource('account', 'AccountController')->middleware(['auth']);
Route::resource('transaction', 'TransactionController')->middleware(['auth']);


Route::get('/statement', 'StatementController@index')->name('statement.index')->middleware(['auth']);
Route::get('/statement/upload', 'StatementController@uploader')->name('statement.uploader')->middleware(['auth']);
Route::post('/statement/upload', 'StatementController@upload')->name('statement.upload')->middleware(['auth']);
Route::get('/statement/{id}', 'StatementController@preview')->name('statement.preview')->middleware(['auth']);
Route::delete('/statement/{id}', 'StatementController@destroy')->name('statement.destroy')->middleware(['auth']);
Route::delete('/statement/{id}/download', 'StatementController@download')->name('statement.download')->middleware(['auth']);