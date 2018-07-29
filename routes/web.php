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

Route::resource('accounts', 'AccountController')->middleware(['auth']);
Route::resource('transactions', 'TransactionController')->middleware(['auth']);


Route::get('/statements', 'StatementController@index')->name('statement.index')->middleware(['auth']);
Route::get('/statements/upload', 'StatementController@uploader')->name('statement.uploader')->middleware(['auth']);
Route::post('/statements/upload', 'StatementController@upload')->name('statement.upload')->middleware(['auth']);
Route::get('/statements/{id}', 'StatementController@preview')->name('statement.preview')->middleware(['auth']);
Route::delete('/statements/{id}', 'StatementController@destroy')->name('statement.destroy')->middleware(['auth']);
Route::delete('/statements/{id}/download', 'StatementController@download')->name('statement.download')->middleware(['auth']);